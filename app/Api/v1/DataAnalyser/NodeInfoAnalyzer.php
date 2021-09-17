<?php

namespace App\Api\v1\DataAnalyser;

use App\Client\CryptoidExplorerClient;
use App\Enum\ServerStatTypes;
use App\Exceptions\AnalyzerException;
use App\Exceptions\Client\CryptoidClientException;
use App\Models\ServerStat;

class NodeInfoAnalyzer extends BaseAnalyzer
{
    public function analyze(): BaseAnalyzer
    {
        return $this->analyzeBlockHeight()
            ->analyzeBlockHash()
            ->analyzeDefidRunning()
            ->analyzeConnectionCount()
            ->analyzeLogSize()
            ->analyzeConfigChecksum()
            ->analyzeOperatorStatus();
    }

    protected function analyzeBlockHeight(): self
    {
        try {
            $localBlockHeight = (int)$this->getAttribute(ServerStatTypes::BLOCK_HEIGHT)->value;
            $mainnetBlockHeight = app(CryptoidExplorerClient::class)->getLatestBlockHeight();
        } catch (AnalyzerException | CryptoidClientException $e) {
            return $this;
        }

        $diffBlockHeight = abs($localBlockHeight - $mainnetBlockHeight);
        if (
            $localBlockHeight < $mainnetBlockHeight
            && $diffBlockHeight > 25
        ) {
            $this->warnings->add([
                'type'      => 'block_height',
                'value'     => $localBlockHeight,
                'expected'  => $mainnetBlockHeight,
                'explained' => sprintf('Node is %s blocks behind main net', $diffBlockHeight),
            ]);
        }

        if (
            $localBlockHeight > $mainnetBlockHeight
            && $diffBlockHeight > 15
        ) {
            $this->critical->add([
                'type'      => 'block_height',
                'value'     => $localBlockHeight,
                'expected'  => $mainnetBlockHeight,
                'explained' => sprintf('Possible chainsplit: node is %s blocks in front of main net', $diffBlockHeight),
            ]);
        }

        $this->result->add([
            'type'    => 'block_height',
            'message' => sprintf('Node\'s block height is at %s, main net is currently at %s', $localBlockHeight,
                $mainnetBlockHeight),
            'value'   => $localBlockHeight,
        ]);

        return $this;
    }

    protected function analyzeBlockHash(): self
    {
        try {
            $localBlockHash = $this->getAttribute(ServerStatTypes::LOCAL_HASH)->value;
            $localBlockHeight = (int)$this->getAttribute(ServerStatTypes::BLOCK_HEIGHT)->value;
            $mainnetBlockHash = app(CryptoidExplorerClient::class)->getLatestBlockHash($localBlockHeight);
        } catch (AnalyzerException | CryptoidClientException $e) {
            return $this;
        }

        if ($localBlockHash !== $mainnetBlockHash) {
            $this->critical->add([
                'type'      => 'block_hash',
                'value'     => $localBlockHash,
                'expected'  => $mainnetBlockHash,
                'explained' => sprintf('Possible chainsplit: Node has different block hash for block %s. ',
                    $localBlockHeight),
            ]);
            $this->result->add([
                'type'     => 'block_hash',
                'message'  => 'Block hashes of the node and the main net are not equal',
                'value'    => $localBlockHeight,
                'expected' => $mainnetBlockHash,
            ]);
        } else {
            $this->result->add([
                'type'     => 'block_hash',
                'message'  => 'Block hashes of the node and the main net are equal',
                'value'    => $localBlockHeight,
                'expected' => $mainnetBlockHash,
            ]);
        }

        return $this;
    }

    protected function analyzeDefidRunning(): self
    {
        try {
            $defidRunning = (bool)$this->getAttribute(ServerStatTypes::DEFID_RUNNING)->value;
        } catch (AnalyzerException $e) {
            return $this;
        }

        if (!$defidRunning) {
            $this->critical->add([
                'type'      => 'defid_running',
                'value'     => $defidRunning,
                'explained' => 'The defid seems not running fine. As long as it is not running, no blocks can be minted.',
            ]);
        }
        $this->result->add([
            'type'    => 'defid_running',
            'message' => sprintf('defid is %srunning', $defidRunning ? '' : 'not '),
            'value'   => $defidRunning,
        ]);

        return $this;
    }

    protected function analyzeConnectionCount(): self
    {
        try {
            $connectionCount = (int)$this->getAttribute(ServerStatTypes::CONNECTION_COUNT)->value;
        } catch (AnalyzerException $e) {
            return $this;
        }

        if ($connectionCount < 5) {
            $this->warnings->add([
                'type'      => 'connection_count',
                'value'     => $connectionCount,
                'explained' => sprintf('At the moment there are only %s connections to the node. Maybe the node recently restartet. Otherwise it\'s recommended to add more connections.',
                    $connectionCount),
            ]);
        }
        $this->result->add([
            'type'    => 'block_hash',
            'message' => 'Block hashes of the node and the main net are equal',
            'value'   => $connectionCount,
        ]);

        return $this;
    }

    protected function analyzeLogSize(): self
    {
        try {
            $logSize = (float)$this->getAttribute(ServerStatTypes::LOGSIZE)->value;
        } catch (AnalyzerException $e) {
            return $this;
        }

        if ($logSize > 20) {
            $this->warnings->add([
                'type'      => 'logsize',
                'value'     => $logSize,
                'explained' => sprintf('The logfile seems to be quite big with %s MB.', $logSize),
            ]);
        }
        $this->result->add([
            'type'    => 'logsize',
            'message' => sprintf('Log file has %s MB at the moment', $logSize),
            'value'   => $logSize,
        ]);

        return $this;
    }

    protected function analyzeConfigChecksum(): self
    {
        try {
            /** @var \App\Models\ServerStat $currentCheckSum */
            $currentCheckSum = $this->getAttribute(ServerStatTypes::CONFIG_CHECKSUM);

            /** @var \App\Models\ServerStat $beforeCheckSum */
            $beforeCheckSum = ServerStat::whereApiKeyId($currentCheckSum->api_key_id)
                ->whereType(ServerStatTypes::CONFIG_CHECKSUM)
                ->orderByDesc('created_at')->skip(1)->take(1)->first();
        } catch (AnalyzerException $e) {
            return $this;
        }
        // if no other checksum is available, skip this analysis
        if (is_null($beforeCheckSum)) {
            return $this;
        }

        if ($currentCheckSum->value !== $beforeCheckSum->value) {
            $this->warnings->add([
                'type'      => 'config_checksum',
                'current'   => $currentCheckSum->value,
                'before'    => $beforeCheckSum->value,
                'explained' => 'The checksum of the defi.conf file changed. If you did not change anything, take a look at this file.',
            ]);
        }
        $this->result->add([
            'type'    => 'config_checksum',
            'message' => sprintf('Current config checkum is %s', $currentCheckSum->value),
            'value'   => $currentCheckSum->value,
        ]);

        return $this;
    }

    protected function analyzeOperatorStatus(): self
    {
        try {
            /** @var \App\Models\ServerStat $currentCheckSum */
            $operatorStatusArray = json_decode($this->getAttribute(ServerStatTypes::OPERATOR_STATUS), true);
        } catch (AnalyzerException $e) {
            return $this;
        }
        $offlineOperator = [];
        $operators = [];
        foreach (json_decode($operatorStatusArray['value'], true) as $operator) {
            $operators[] = $operator;
            if (!$operator['online']) {
                $offlineOperator[] = $operator;
            }
        }

        $countOfflineOperators = count($offlineOperator);
        if ($countOfflineOperators > 0) {
            $this->critical->add([
                'type'      => 'operator_status',
                'value'     => $offlineOperator,
                'explained' => sprintf('%s operator not online at the moment', $countOfflineOperators),
            ]);
        }

        $this->result->add([
            'type'    => 'operator_status',
            'message' => sprintf(
                '%s operator online, %s operator offline',
                count($operatorStatusArray) - $countOfflineOperators,
                $countOfflineOperators
            ),
            'value'   => $operators,
        ]);

        return $this;
    }
}
