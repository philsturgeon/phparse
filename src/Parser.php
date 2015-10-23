<?php namespace Sturgeon\PHPArse;

use Naneau\SemVer\Parser as SemVerParser;
use DOMDocument;
use DOMXpath;

class Parser
{
    protected $xpath;

    public function __construct($html)
    {
        $this->xpath = $this->loadXPathDocument($html);
    }

    public function detectVersion()
    {
        $node = $this->xpath->query('//body//h1')[0];
        $versionString = str_replace('PHP Version ', '', $node->nodeValue);
        return $this->convertToSemver($versionString);
    }

    private function convertToSemver($versionString)
    {
        return SemVerParser::parse($versionString);
    }

    private function loadXPathDocument($html)
    {
        $document = new DOMDocument;
        $document->loadHTML($html);
        return new DOMXpath($document);
    }
}
