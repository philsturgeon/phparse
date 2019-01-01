<?php

declare(strict_types=1);

namespace PhpVersions\PHParse;

use DOMDocument;
use DOMXpath;
use PhpVersions\PHParse\Exceptions\NoPhpVersionsFileException;

class Parser
{
    protected $xpath;

    /** @var string */
    private $html;

    public static function readFromUrl($url)
    {
        $html = file_get_contents($url);
        return new static($html);
    }

    public function __construct(string $html)
    {
        $this->xpath = $this->loadXPathDocument($html);
        if (! $this->isValidPhpInfoHtml()) {
            throw new \Exception('The HTML does not contain valid phpinfo() output');
        }
    }

    public function parse() : Info
    {
        return new Info($this->locatePhpVersion(), $this->locateGeneralInfo());
    }

    public function locatePhpVersion() : string
    {
        $node = $this->xpath->query('//body//h1')[0];

        return str_replace('PHP Version ', '', $node->nodeValue);
    }

    public function locateGeneralInfo() : array
    {
        $rows = $this->xpath->query('//body//table[2]/tr');

        $infoPairs = [];

        foreach ($rows as $row) {
            $label = $this->cleanLabel($row->firstChild->textContent);
            $value = $this->cleanValue($row->lastChild->textContent);
            $infoPairs[$label] = $value;
        }

        return $infoPairs;
    }

    private function cleanLabel($label) : string
    {
        return trim($label);
    }

    private function cleanValue($label) : string
    {
        return trim($label);
    }

    private function loadXPathDocument($html) : DOMXpath
    {
        $document = new DOMDocument;
        $document->loadHTML($html);
        return new DOMXpath($document);
    }

    private function isValidPhpInfoHtml() : bool
    {
        return strpos($this->xpath->query('//head//title')[0]->nodeValue, 'phpinfo()') !== false;
    }
}
