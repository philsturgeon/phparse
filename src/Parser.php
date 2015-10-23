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

    public function parse()
    {
        return Info($this->phpVersion(), $this->generalInfo());
    }

    public function phpVersion()
    {
        $node = $this->xpath->query('//body//h1')[0];
        return str_replace('PHP Version ', '', $node->nodeValue);
    }
    
    private function generalInfo()
    {
        $table = $this->xpath->query('//body//table[2]');
        $rows = $table->children();
        return $rows;
    }

    private function loadXPathDocument($html)
    {
        $document = new DOMDocument;
        $document->loadHTML($html);
        return new DOMXpath($document);
    }
}
