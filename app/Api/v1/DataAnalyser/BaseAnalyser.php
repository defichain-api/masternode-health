<?php

namespace App\Api\v1\DataAnalyser;

use Illuminate\Support\Collection;

abstract class BaseAnalyser
{
    protected Collection $analyserOutput;
    protected Collection $warnings;
    protected Collection $fatalErrors;

    public function __construct()
    {
        $this->analyserOutput = new Collection();
        $this->warnings = new Collection();
        $this->fatalErrors = new Collection();
    }

    abstract public function analyse(): self;

//    final public function hasWarnings(): bool
//    {
//        return $this->warnings->count() > 0;
//    }

    final public function getWarnings(): Collection
    {
        return $this->warnings;
    }

//    final public function hasFatalErrors(): bool
//    {
//        return $this->fatalErrors->count() > 0;
//    }

    final public function getFatalErrors(): Collection
    {
        return $this->fatalErrors;
    }

    final public function getAnalyserOutput(): Collection
    {
        return $this->analyserOutput;
    }

    final public function getResult(): array
    {
        return [
            'analysis_result' => $this->getAnalyserOutput()->toArray(),
            'warnings'        => $this->getWarnings()->toArray(),
            'fatal_errors'    => $this->getFatalErrors()->toArray(),
        ];
    }
}
