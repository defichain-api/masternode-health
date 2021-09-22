<?php

namespace Tests\Unit;

use App\Api\v1\DataAnalyser\ServerStatAnalyzer;
use App\Client\MnHealthScriptVersion;
use App\Enum\ServerStatTypes;
use App\Models\ApiKey;
use App\Models\ServerStat;
use App\Repository\ServerStatRepository;
use Tests\TestCase;

class ServerStatAnalyzerTest extends TestCase
{
    protected ApiKey $apiKey;
    protected ServerStatAnalyzer $serverStatAnalyzer;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiKey = ApiKey::factory()->create();
        $this->serverStatAnalyzer = new ServerStatAnalyzer();
    }

    public function test_load_avg_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOAD_AVG, 0.5)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::NUM_CORES, 2)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('The current load avg of the latest 5min is 0.5', $result['analysis_result'][0]['message']);
        $this->assertEquals('load_avg', $result['analysis_result'][0]['type']);
        $this->assertEquals(0.5, $result['analysis_result'][0]['value']);
    }

    public function test_load_avg_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOAD_AVG, 2.81)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::NUM_CORES, 2)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('The current load (2.81) of this server needs your attention', $result['warnings'][0]['explained']);
        $this->assertEquals('load_avg', $result['warnings'][0]['type']);
        $this->assertEquals(2.81, $result['warnings'][0]['value']);
    }

    public function test_load_avg_critical_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOAD_AVG, 4.01)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::NUM_CORES, 2)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('The current load (4.01) of this server seems to be critical', $result['critical'][0]['explained']);
        $this->assertEquals('load_avg', $result['critical'][0]['type']);
        $this->assertEquals(4.01, $result['critical'][0]['value']);
    }

    public function test_hdd_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_USED, 45)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_TOTAL, 100)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('0.45 percent of your HDD capacity used', $result['analysis_result'][0]['message']);
        $this->assertEquals('hdd', $result['analysis_result'][0]['type']);
        $this->assertEquals(0.45, $result['analysis_result'][0]['value']);
    }

    public function test_hdd_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_USED, 80.5)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_TOTAL, 100)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('0.81 percent of your HDD capacity used', $result['warnings'][0]['explained']);
        $this->assertEquals('hdd', $result['warnings'][0]['type']);
        $this->assertEquals(0.81, $result['warnings'][0]['value']);
    }

    public function test_hdd_critical_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_USED, 95.21)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::HDD_TOTAL, 100)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('0.95 percent of your HDD capacity used', $result['critical'][0]['explained']);
        $this->assertEquals('hdd', $result['critical'][0]['type']);
        $this->assertEquals(0.95, $result['critical'][0]['value']);
    }

    public function test_ram_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_USED, 5)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_TOTAL, 10)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('0.5 percent of your RAM capacity used', $result['analysis_result'][0]['message']);
        $this->assertEquals('ram', $result['analysis_result'][0]['type']);
        $this->assertEquals(0.5, $result['analysis_result'][0]['value']);
    }

    public function test_ram_warning_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_USED, 8.01)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_TOTAL, 10)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals('0.8 percent of your RAM capacity used', $result['warnings'][0]['explained']);
        $this->assertEquals('ram', $result['warnings'][0]['type']);
        $this->assertEquals(0.8, $result['warnings'][0]['value']);
    }

    public function test_ram_critical_analyzer(): void
    {
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_USED, 9.51)
            ->apiKey($this->apiKey->key())
            ->create();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_TOTAL, 10)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(1, count($result['critical']));
        $this->assertEquals('0.95 percent of your RAM capacity used', $result['critical'][0]['explained']);
        $this->assertEquals('ram', $result['critical'][0]['type']);
        $this->assertEquals(0.95, $result['critical'][0]['value']);
    }

    public function test_server_script_version_analyzer(): void
    {
        $currentVersion = app(MnHealthScriptVersion::class)->getCurrentVersion();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::SERVER_SCRIPT_VERSION, $currentVersion)
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();

        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(0, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals(sprintf('Installed 1.0.3, current version installable %s',$currentVersion),
            $result['analysis_result'][0]['message']);
        $this->assertEquals('server_script_version', $result['analysis_result'][0]['type']);
        $this->assertEquals($currentVersion, $result['analysis_result'][0]['value']);
    }

    public function test_server_script_version_warning_analyzer(): void
    {
        $currentVersion = app(MnHealthScriptVersion::class)->getCurrentVersion();
        ServerStat::factory()
            ->serverStat(ServerStatTypes::SERVER_SCRIPT_VERSION, '1.0.2')
            ->apiKey($this->apiKey->key())
            ->create();
        $resourceCollection = app(ServerStatRepository::class)->getLatestServerStatForApiKey($this->apiKey);
        $result = $this->serverStatAnalyzer->withCollection($resourceCollection)->analyze()->result();
        ray($result);
        $this->assertEquals(1, count($result['analysis_result']));
        $this->assertEquals(1, count($result['warnings']));
        $this->assertEquals(0, count($result['critical']));
        $this->assertEquals(sprintf('Installed 1.0.2, current version installable %s',$currentVersion),
            $result['analysis_result'][0]['message']);
        $this->assertEquals('server_script_version', $result['analysis_result'][0]['type']);
        $this->assertEquals('1.0.2', $result['analysis_result'][0]['value']);

        $this->assertEquals('server_script_version', $result['warnings'][0]['type']);
        $this->assertEquals('1.0.2', $result['warnings'][0]['value']);
        $this->assertEquals($currentVersion, $result['warnings'][0]['expected']);
        $this->assertEquals('Installed 1.0.2 but current version is 1.0.3. Please upgrade with `pip3 install --upgrade masternode-health`', $result['warnings'][0]['explained']);
    }
}
