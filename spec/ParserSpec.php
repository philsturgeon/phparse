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

    describe('->phpVersion()', function() {
        context('with a nice easy 5.6 instllation', function() {
            beforeEach(function() {
                $html = file_get_contents('http://localhost:8000/?version=5.6.12');
                $this->parse = new Parser($html);
            });

            it("returns '5.6.12' when typecast as string", function() {
              expect($this->parse->phpVersion())->toBe('5.6.12');
            });

            it("returns '5.6.12' when typecast as string", function() {
              expect($this->parse->generalInfo())->toBe([]);
            });
        });

        context('with some batshit custom host verison', function() {
            beforeEach(function() {
                $html = file_get_contents('http://php56.hosteurope-infos.de/phpinfo.php');
                $this->parse = new Parser($html);
            });

            it("returns '5.6.12' when typecast as string", function() {
              expect($this->parse->phpVersion())->toBe('5.6.14-1~he.1');
            });
        });
    });
});
