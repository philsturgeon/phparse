<?php

declare(strict_types=1);

namespace PhpVersions;

use PHPUnit\Framework\TestCase;
use PhpVersions\PHParse\Info;

class InfoTest extends TestCase
{
    /** @var string */
    private $version;

    /** @var array */
    private $infoItems;

    /** @var Info */
    private $info;

    public function setup() : void
    {
        $this->version = '7.3.0';
        $this->infoItems = [];

        $this->info = new Info($this->version, $this->infoItems);
    }

    public function testCanGetInstance() : void
    {
        $this->assertInstanceOf(Info::class, $this->info);
    }

    public function testCanGetPhpVersion() : void
    {
        $version = $this->info->phpVersion();

        $this->assertSame($this->version, $version);
    }

    public function testCanGetPhpSemanticVersion() : void
    {
        $semanticVersion = $this->info->phpSemanticVersion();

        $version = explode('.', $this->version);

        $this->assertIsObject($semanticVersion);
        $this->assertSame((int) $version[0], $semanticVersion->getMajor());
        $this->assertSame((int) $version[1], $semanticVersion->getMinor());
        $this->assertSame((int) $version[2], $semanticVersion->getPatch());
        $this->assertSame($this->version, $semanticVersion->getOriginalVersion());
    }
}
