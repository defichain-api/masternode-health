<?php

namespace Tests\Unit;

use App\Api\v1\DataAnalyser\NodeInfoAnalyzer;
use App\Client\CryptoidExplorerClient;
use App\Client\DefidVersion;
use App\Enum\ServerStatTypes;
use App\Models\ApiKey;
use App\Models\ServerStat;
use App\Repository\ServerStatRepository;
use Tests\TestCase;

class NodeInfoAnalyzerTest extends TestCase
{
    protected ApiKey $apiKey;
    protected NodeInfoAnalyzer $nodeInfoAnalyzer;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiKey = ApiKey::factory()->create();
        $this->nodeInfoAnalyzer = new NodeInfoAnalyzer();
    }

    public function test_block_height_analyzer(): void
    {
        $mainnetBlockHeight = app(CryptoidExplorerClient::class)->getLatestBlockHeight();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, $mainnetBlockHeight)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals(sprintf('Node\'s block height is at %s, main net is currently at %s',
            $mainnetBlockHeight, $mainnetBlockHeight), $result['analysis_result'][0]['message']);
        $this->assertEquals('block_height', $result['analysis_result'][0]['type']);
        $this->assertEquals($mainnetBlockHeight, $result['analysis_result'][0]['value']);
    }

    public function test_block_height_warning_analyzer(): void
    {
        $mainnetBlockHeight = app(CryptoidExplorerClient::class)->getLatestBlockHeight();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, $mainnetBlockHeight - 26)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('Node is 26 blocks behind main net', $result['warnings'][0]['explained']);
        $this->assertEquals('block_height', $result['warnings'][0]['type']);
        $this->assertEquals($mainnetBlockHeight - 26, $result['warnings'][0]['value']);
        $this->assertEquals($mainnetBlockHeight, $result['warnings'][0]['expected']);
    }

    public function test_block_height_critical_analyzer(): void
    {
        $mainnetBlockHeight = app(CryptoidExplorerClient::class)->getLatestBlockHeight();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, $mainnetBlockHeight + 16)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('Possible chainsplit: node is 16 blocks in front of main net',
            $result['critical'][0]['explained']);
        $this->assertEquals('block_height', $result['critical'][0]['type']);
        $this->assertEquals($mainnetBlockHeight + 16, $result['critical'][0]['value']);
        $this->assertEquals($mainnetBlockHeight, $result['critical'][0]['expected']);
    }

    public function test_block_hash_analyzer(): void
    {
        $cryptiodExplorerClient = app(CryptoidExplorerClient::class);
        $latestBlockHeight = $cryptiodExplorerClient->getLatestBlockHeight();
        $latestBlockHash = $cryptiodExplorerClient->getLatestBlockHash($latestBlockHeight);
        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, $latestBlockHeight)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOCAL_HASH, $latestBlockHash)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(2, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('Block hashes of the node and the main net are equal',
            $result['analysis_result'][1]['message']);
        $this->assertEquals('block_height', $result['analysis_result'][0]['type']);
        $this->assertEquals('block_hash', $result['analysis_result'][1]['type']);
        $this->assertEquals($latestBlockHash, $result['analysis_result'][1]['value']);
    }

    public function test_block_hash_critical_analyzer(): void
    {
        $cryptiodExplorerClient = app(CryptoidExplorerClient::class);
        $latestBlockHeight = $cryptiodExplorerClient->getLatestBlockHeight();
        $latestBlockHash = $cryptiodExplorerClient->getLatestBlockHash($latestBlockHeight);
        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, $latestBlockHeight)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOCAL_HASH, $latestBlockHash . 'invalid')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(2, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals(sprintf('Possible chainsplit: Node has different block hash for block %s.',
            $latestBlockHeight),
            $result['critical'][0]['explained']);
        $this->assertEquals('block_hash', $result['critical'][0]['type']);
        $this->assertEquals($latestBlockHash . 'invalid', $result['critical'][0]['value']);
        $this->assertEquals($latestBlockHash, $result['critical'][0]['expected']);
    }

    public function test_defid_running_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::DEFID_RUNNING, 1)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('defid is running', $result['analysis_result'][0]['message']);
        $this->assertEquals('defid_running', $result['analysis_result'][0]['type']);
        $this->assertEquals(true, $result['analysis_result'][0]['value']);
    }

    public function test_defid_running_critical_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::DEFID_RUNNING, 0)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('defid is not running', $result['analysis_result'][0]['message']);
        $this->assertEquals('defid_running', $result['analysis_result'][0]['type']);
        $this->assertEquals(false, $result['analysis_result'][0]['value']);

        $this->assertEquals('The defid service seems to be either not running or not responding. It is possible that your node won\'t mint new blocks.',
            $result['critical'][0]['explained']);
        $this->assertEquals('defid_running', $result['critical'][0]['type']);
        $this->assertEquals(false, $result['critical'][0]['value']);
    }

    public function test_connection_count_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONNECTION_COUNT, 10)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('The node has 10 active connections', $result['analysis_result'][0]['message']);
        $this->assertEquals('connection_count', $result['analysis_result'][0]['type']);
        $this->assertEquals(10, $result['analysis_result'][0]['value']);
    }

    public function test_connection_count_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONNECTION_COUNT, 4)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('At the moment there are only 4 connections to the node. Maybe the node recently restartet. Otherwise it\'s recommended to add more connections.',
            $result['warnings'][0]['explained']);
        $this->assertEquals('connection_count', $result['warnings'][0]['type']);
        $this->assertEquals(4, $result['warnings'][0]['value']);
    }

    public function test_logsize_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOGSIZE, 13.37)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('Log file has 13.37 MB at the moment', $result['analysis_result'][0]['message']);
        $this->assertEquals('logsize', $result['analysis_result'][0]['type']);
        $this->assertEquals(13.37, $result['analysis_result'][0]['value']);
    }

    public function test_logsize_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOGSIZE, 21.37)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('The logfile appears to be quite big with 21.37 MB.', $result['warnings'][0]['explained']);
        $this->assertEquals('logsize', $result['warnings'][0]['type']);
        $this->assertEquals(21.37, $result['warnings'][0]['value']);
    }

    public function test_config_checksum_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONFIG_CHECKSUM, 'a3cca2b2aa1e3b5b3b5aad99a8529074')
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONFIG_CHECKSUM, 'a3cca2b2aa1e3b5b3b5aad99a8529074')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('Current config checkum is a3cca2b2aa1e3b5b3b5aad99a8529074',
            $result['analysis_result'][0]['message']);
        $this->assertEquals('config_checksum', $result['analysis_result'][0]['type']);
        $this->assertEquals('a3cca2b2aa1e3b5b3b5aad99a8529074', $result['analysis_result'][0]['value']);
    }

    public function test_config_checksum_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONFIG_CHECKSUM, 'a3cca2b2aa1e3b5b3b5aad99a8529074')
            ->apiKey($this->apiKey->key())
            ->create();
        sleep(1);
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONFIG_CHECKSUM, 'a3cca2b2aa1e3b5b3b5aad99a8529075')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('The checksum of the defi.conf file changed. If you did not change anything, take a look at this file.',
            $result['warnings'][0]['explained']);
        $this->assertEquals('config_checksum', $result['warnings'][0]['type']);
        $this->assertEquals('a3cca2b2aa1e3b5b3b5aad99a8529075', $result['warnings'][0]['current']);
        $this->assertEquals('a3cca2b2aa1e3b5b3b5aad99a8529074', $result['warnings'][0]['before']);
    }

    public function test_config_checksum_skipped_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::CONFIG_CHECKSUM, 'a3cca2b2aa1e3b5b3b5aad99a8529074')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();
        ray($result);
        $this->assertEquals(0, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
    }

    public function test_operator_status_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::OPERATOR_STATUS,
                '[{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d7asdsa9108951faecf715e1e1a57","online":true}]')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('1 operator online, 0 operator offline', $result['analysis_result'][0]['message']);
        $this->assertEquals('operator_status', $result['analysis_result'][0]['type']);
        $this->assertEquals([
            0 => [
                "id"     => "2ceb7c9c3bea0bd0e5e4199eca5d0b797d7asdsa9108951faecf715e1e1a57",
                "online" => true,
            ],
        ], $result['analysis_result'][0]['value']);
    }

    public function test_operator_status_critical_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::OPERATOR_STATUS,
                '[{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d7asdsa9108951faecf715e1e1a57","online":true},{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d7asdsa9108951faecf715e1e1a57","online":false}]')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('1 operator online, 1 operator offline', $result['analysis_result'][0]['message']);
        $this->assertEquals('operator_status', $result['analysis_result'][0]['type']);

        $this->assertEquals('1 operator not online at the moment', $result['critical'][0]['explained']);
        $this->assertEquals('operator_status', $result['critical'][0]['type']);
        $this->assertEquals([
            0 => [
                "id"     => "2ceb7c9c3bea0bd0e5e4199eca5d0b797d7asdsa9108951faecf715e1e1a57",
                "online" => false,
            ],
        ], $result['critical'][0]['value']);
    }

    public function test_defid_status_analyzer(): void
    {
        $defid = app(DefidVersion::class)->getCurrentVersion();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::NODE_VERSION,$defid)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals(sprintf('Installed %s, current version installable %s', $defid, $defid),
            $result['analysis_result'][0]['message']);
        $this->assertEquals('node_version', $result['analysis_result'][0]['type']);
        $this->assertEquals($defid, $result['analysis_result'][0]['value']);
    }

    public function test_defid_status_warning_analyzer(): void
    {
        $defid = app(DefidVersion::class)->getCurrentVersion();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::NODE_VERSION,'1.8.1')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($this->apiKey);
        $result = $this->nodeInfoAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals(sprintf('Installed 1.8.1 but current version is %s. Please upgrade to current version',
        $defid),
            $result['warnings'][0]['explained']);
        $this->assertEquals('node_version', $result['warnings'][0]['type']);
        $this->assertEquals('1.8.1', $result['warnings'][0]['value']);
        $this->assertEquals($defid, $result['warnings'][0]['expected']);
    }
}
