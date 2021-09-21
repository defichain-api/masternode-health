<?php

namespace App\Api\v1\DataAnalyser;

use App\Client\MnHealthScriptVersion;
use App\Enum\Cooldown;
use App\Enum\ServerStatTypes;
use App\Exceptions\AnalyzerException;
use App\Helper\Version;
use App\Models\ServerStat;

class ServerStatAnalyzer extends BaseAnalyzer
{
    public function analyze(): BaseAnalyzer
    {
        return $this
            ->analyzeLoadAvg()
            ->analyzeHdd()
            ->analyzeRam()
            ->analyzeServerScriptVersion();
    }

    protected function analyzeLoadAvg(): self
    {
        try {
            $loadAvg = (float)$this->getAttribute(ServerStatTypes::LOAD_AVG)->value;
            $cores = $this->getAttribute(ServerStatTypes::NUM_CORES)->value;
        } catch (AnalyzerException $e) {
            return $this;
        }

        if ($loadAvg >= $cores * 2) {
            $this->critical->add([
                'type'      => 'load_avg',
                'value'     => $loadAvg,
                'explained' => sprintf('The current load (%s) of this server seems to be critical', $loadAvg),
            ]);
        } elseif ($loadAvg >= $cores) {
            $this->warnings->add([
                'type'      => 'load_avg',
                'value'     => $loadAvg,
                'explained' => sprintf('The current load (%s) of this server needs your attention', $loadAvg),
            ]);
        }

        $this->result->add([
            'type'    => 'load_avg',
            'message' => sprintf('The current load avg of the latest 5min is %s', $loadAvg),
            'value'   => $loadAvg,
        ]);

        return $this;
    }

    protected function analyzeHdd(): self
    {
        try {
            /** @var Serverstat $usedValue */
            /** @var Serverstat $totalValue */
            $usedValue = $this->getAttribute(ServerStatTypes::HDD_USED);
            $totalValue = $this->getAttribute(ServerStatTypes::HDD_TOTAL);
            $currentRatio = round($usedValue->value / $totalValue->value, 2, PHP_ROUND_HALF_UP);
        } catch (AnalyzerException $e) {
            return $this;
        }

        if ($currentRatio > 0.8) {
            $this->warnings->add([
                'type'      => 'hdd',
                'value'     => $currentRatio,
                'explained' => sprintf('%s percent of your HDD capacity used', $currentRatio),
            ]);
        } elseif ($currentRatio > 0.95) {
            $this->critical->add([
                'type'      => 'hdd',
                'value'     => $currentRatio,
                'explained' => sprintf('%s percent of your HDD capacity used', $currentRatio),
            ]);
        }

        $this->result->add([
            'type'    => 'hdd',
            'message' => sprintf('%s percent of your HDD capacity used', $currentRatio),
            'value'   => $currentRatio,
        ]);

        return $this;
    }

    protected function analyzeRam(): self
    {
        try {
            /** @var Serverstat $usedValue */
            /** @var Serverstat $totalValue */
            $usedValue = $this->getAttribute(ServerStatTypes::RAM_USED);
            $totalValue = $this->getAttribute(ServerStatTypes::RAM_TOTAL);
            $currentRatio = round($usedValue->value / $totalValue->value, 2, PHP_ROUND_HALF_UP);
        } catch (AnalyzerException $e) {
            return $this;
        }

        if ($currentRatio > 0.8) {
            $this->warnings->add([
                'type'      => 'ram',
                'value'     => $currentRatio,
                'explained' => sprintf('%s percent of your RAM capacity used', $currentRatio),
            ]);
        } elseif ($currentRatio > 0.95) {
            $this->critical->add([
                'type'      => 'ram',
                'value'     => $currentRatio,
                'explained' => sprintf('%s percent of your RAM capacity used', $currentRatio),
            ]);
        }

        $this->result->add([
            'type'    => 'ram',
            'message' => sprintf('%s percent of your RAM capacity used', $currentRatio),
            'value'   => $currentRatio,
        ]);

        return $this;
    }

    protected function analyzeServerScriptVersion(): self
    {
        try {
            /** @var Serverstat $localVersion */
            $localVersion = $this->getAttribute(ServerStatTypes::SERVER_SCRIPT_VERSION)->value;
        } catch (AnalyzerException $e) {
            return $this;
        }
        $mnScriptVersion = app(MnHealthScriptVersion::class)->getCurrentVersion();

        if (Version::getVersionAsInt($localVersion) < Version::getVersionAsInt($mnScriptVersion)) {
            $this->warnings->add([
                'type'      => 'server_script_version',
                'value'     => $localVersion,
                'expected'  => $mnScriptVersion,
                'explained' => sprintf('Installed %s but current version is %s. Please upgrade with `pip3 install --upgrade masternode-health`',
                    $localVersion,
                    $mnScriptVersion),
            ]);
        }

        $this->result->add([
            'type'    => 'server_script_version',
            'message' => sprintf('Installed %s, current version installable %s', $localVersion, $mnScriptVersion),
            'value'   => $localVersion,
        ]);

        return $this;
    }
}
