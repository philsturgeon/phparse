<?php

declare(strict_types=1);

namespace PhpVersions;

use PHPUnit\Framework\TestCase;
use PhpVersions\PHParse\Info;
use PhpVersions\PHParse\Parser;

class ParserTest extends TestCase
{
    private const CURRENT_VERSION = '7.3.0';

    /** @var Parser */
    private $parser;

    public function setup() : void
    {
        $html = file_get_contents(__DIR__ . '/../../test-info.html');

        $this->parser = new Parser($html);
    }

    public function testCanGetInstanceOf() : void
    {
        $this->assertInstanceOf(Parser::class, $this->parser);
    }

    public function testCanParseInfo() : void
    {
        $info = $this->parser->parse();

        $this->assertInstanceOf(Info::class, $info);
    }

    public function testLocatePhpVersion() : void
    {
        $version = $this->parser->locatePhpVersion();

        $this->assertSame(self::CURRENT_VERSION, $version);
    }

    public function testLocatePhpInfo() : void
    {
        $info = $this->parser->locateGeneralInfo();

        $this->assertTrue(is_array($info));
        $this->assertArrayHasKey('PHP Extension', $info);
        $this->assertArrayHasKey('PHP API', $info);
        $this->assertArrayHasKey('Server API', $info);
    }
}
