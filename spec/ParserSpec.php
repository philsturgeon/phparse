<?php

use Sturgeon\PHPArse\Parser;
use VCR\VCR;

describe(Parser::class, function() {
    before(function() {
        VCR::insertCassette('phpinfos');
    });

    after(function() {
        VCR::eject();
    });

    beforeEach(function() {
        $html = file_get_contents('http://localhost:8000/?version=5.6.12');
        $this->parse = new Parser($html);
    });

    describe('->phpVersion()', function() {
        it("returns '5.6.12' when typecast as string", function() {
          expect($this->parse->phpVersion())->toBe('5.6.12');
        });
    });

    describe('->generalInfo()', function() {
        it("returns a few key items", function() {
          $info = $this->parse->generalInfo();
          expect($info)->toContainKey('Build Date');
          expect($info)->toContainKey('Configure Command');
          expect($info)->toContainKey('Server API');
        });
    });
});
