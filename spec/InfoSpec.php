<?php

use Naneau\SemVer\Parser as SemVerParser;
use Sturgeon\PHPArse\Info;
use VCR\VCR;

const NUTTY_HOST_VERSION = '5.6.14-1~he.1';
const STANDARD_VERSION = '5.6.14';

describe(Info::class, function() {
    describe('->phpVersion()', function() {
        context('with a nutty bullshit custom host version', function() {
            it("returns said nutty bullshit version '5.6.14-1~he.1'", function() {
              $info = new Info(NUTTY_HOST_VERSION);
              expect($info->phpVersion())->toBe(NUTTY_HOST_VERSION);
            });
        });
    });

    describe('->phpSemanticVersion()', function() {
        context('with a standard version number', function() {
            beforeEach(function() { 
                $info = new Info(STANDARD_VERSION);
                $this->semver = $info->phpSemanticVersion();
            });

            it("returns major version of int(5)", function() {
                expect($this->semver->getMajor())->toBe(5);
            });
            
            it("returns minor version of int(5)", function() {
                expect($this->semver->getMinor())->toBe(6);
            });
            
            it("returns patch version of int(5)", function() {
                expect($this->semver->getPatch())->toBe(14);
            });
        });

        context('with a nutty bullshit custom host version', function() {
            beforeEach(function() { 
                $this->info = new Info(NUTTY_HOST_VERSION);
            });

            it("falls over entirely because it isn't SemVer", function() {
                expect(function() { $this->info->phpSemanticVersion(); })->toThrow(new InvalidArgumentException);
            });
        });
    });
});
