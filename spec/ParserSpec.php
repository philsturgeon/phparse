<?php

use Sturgeon\PHPArse\Parser;
use VCR\VCR;

describe('Parser', function() {
    before(function() {
        VCR::insertCassette('phpinfos');
    });

    after(function() {
        VCR::eject();
    });

    describe('->detectVersion()', function() {
        context('with a nice easy 5.6 instllation', function() {
            beforeEach(function() {
                $html = file_get_contents('http://localhost:8000/?version=5.6.12');
                $parse = new Parser($html);
                $this->version = $parse->detectVersion();
            });

            it("returns '5.6.12' when typecast as string", function() {
              expect((string) $this->version)->toBe('5.6.12');
            });

            it("returns major version of '5'", function() {
              expect($this->version->getMajor())->toBe(5);
            });

            it("returns major version of '6'", function() {
              expect($this->version->getMinor())->toBe(6);
            });

            it("returns major version of '12'", function() {
              expect($this->version->getPatch())->toBe(12);
            });
        });

        context('with some batshit custom host verison', function() {
            beforeEach(function() {
                $html = file_get_contents('http://php56.hosteurope-infos.de/phpinfo.php');
                $parse = new Parser($html);
                $this->version = $parse->detectVersion();
            });

            it("returns '5.6.12' when typecast as string", function() {
              expect((string) $this->parse->detectVersion())->toBe('5.6.12');
            });

            it("returns major version of '5'", function() {
              expect((string) $this->parse->detectVersion()->getMajor())->toBe("5");
            });

            it("returns major version of '6'", function() {
              expect((string) $this->parse->detectVersion()->getMajor())->toBe("5");
            });

            it("returns major version of '12'", function() {
              expect((string) $this->parse->detectVersion()->getMajor())->toBe("5");
            });
        });
    });
});
