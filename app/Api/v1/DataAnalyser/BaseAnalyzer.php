<?php

namespace App\Api\v1\DataAnalyser;

use App\Exceptions\AnalyzerException;
use App\Models\ApiKey;
use App\Models\ServerStat;
use Illuminate\Support\Collection;

abstract class BaseAnalyzer
{
    protected Collection $result;
    protected Collection $warnings;
    protected Collection $critical;
    protected Collection $serverStats;
    protected ApiKey $apiKey;

    public function withCollection(Collection $serverStats): self
    {
        $this->result = new Collection();
        $this->warnings = new Collection();
        $this->critical = new Collection();
        $this->serverStats = $serverStats;
        $this->apiKey = $serverStats->first()->apiKey;

        return $this;
    }

    abstract public function analyze(): self;

    final public function getApiKey(): ApiKey
    {
        return $this->apiKey;
    }

    /**
     * @throws \App\Exceptions\AnalyzerException
     */
    final protected function getAttribute(string $attributeName): ServerStat
    {
        $attribute = $this->serverStats->filter(function (ServerStat $serverStat) use ($attributeName) {
            return $serverStat->type === $attributeName;
        })->first();
        throw_if(is_null($attribute), AnalyzerException::attributeNotFound($attributeName));

        return $attribute;
    }

    final public function hasWarnings(): bool
    {
        return $this->warnings->count() > 0;
    }

    final public function hasFatalErrors(): bool
    {
        return $this->critical->count() > 0;
    }

    final public function result(): array
    {
        return [
            'analysis_result' => $this->result->toArray(),
            'warnings'        => $this->warnings->toArray(),
            'critical'        => $this->critical->toArray(),
        ];
    }

    final public function checkRelevanceForApiKey(string $infoType, int $checkOccurence = 3): bool
    {
        $cacheKey = sprintf('%s_%s', $infoType, md5($this->getApiKey()));
        cache()->increment($cacheKey);

        if (cache($cacheKey) >= $checkOccurence) {
            cache()->forget($cacheKey);

            return true;
        }

        return false;
    }

    final public function resetRelevanceForApiKey(string $infoType): bool
    {
        $cacheKey = sprintf('%s_%s', $infoType, md5($this->getApiKey()));

        return cache()->forget($cacheKey);
    }
}
