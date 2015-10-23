<?php namespace Sturgeon\PHPArse;

use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    protected $crawler;

    public function __construct($html)
    {
      $this->crawler = new Crawler($html);
    }
    
    public function detectVersion()
    {
        return str_replace('PHP Version ', '', $this->crawler->filterXPath('//body//h1')->text());
    }
}
