<?php

namespace Tests\Unit;

use App\Helper\Version;
use Tests\TestCase;

class VersionTest extends TestCase
{
    public function test_version_to_string(): void
    {
        $this->assertEquals('1.0.1', Version::getVersionAsString('v1.0.1'));
        $this->assertEquals('1.0.2', Version::getVersionAsString('v1.0.2-release'));
        $this->assertEquals('1.0.3', Version::getVersionAsString('1.0.3-release'));
    }

    public function test_version_to_int(): void
    {
        $this->assertEquals(101, Version::getVersionAsInt('v1.0.1'));
        $this->assertEquals(102, Version::getVersionAsInt('v1.0.2-release'));
        $this->assertEquals(103, Version::getVersionAsInt('1.0.3-release'));
    }
}
