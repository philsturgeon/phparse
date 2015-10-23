<?php

use Sturgeon\PHPArse\Info;
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
        $url = 'http://localhost:8000/?version=5.6.12';
        $this->parser = Parser::readFromUrl($url);
    });

    describe('->parse()', function() {
        it('returns an instance of info, which is probably correct', function() {
            expect($this->parser->parse())->toBeAnInstanceOf(Info::class);
        });
    });

    describe('->locatePhpVersion()', function() {
        it("returns '5.6.12'", function() {
            expect($this->parser->locatePhpVersion())->toBe('5.6.12');
        });
    });

    describe('->locateGeneralInfo()', function() {
        it("returns a few key items", function() {
          $info = $this->parser->locateGeneralInfo();
          expect($info)->toContainKey('Build Date');
          expect($info)->toContainKey('Configure Command');
          expect($info)->toContainKey('Server API');
        });
    });
});
