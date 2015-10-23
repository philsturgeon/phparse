<?php namespace Sturgeon\PHPArse;

use Naneau\SemVer\Parser as SemVerParser;

class Info
{
    public function __construct($version, array $infoItems = [])
    {
        $this->version = $version;
        $this->infoItems = $infoItems;
    }
    
    public function phpVersion()
    {
        return $this->version;
    }

    public function phpSemanticVersion()
    {
        return SemVerParser::parse($this->version);
    }
}
