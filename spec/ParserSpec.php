<?php

use Sturgeon\PHPArse\Parser;
use VCR\VCR;

describe('Parser', function() {
    before(function() {
        VCR::turnOn();
        VCR::insertCassette('local');
    });
    
    after(function() {
        VCR::eject();
        VCR::turnOff();
    });

    beforeEach(function() {
        $html = file_get_contents('http://localhost:8000/?version=5.6.12');
        $this->parse = new Parser($html);
    });

    describe('->detectVersion()', function() {
        
        it("should shit HTML everywhere", function() {
          expect($this->parse->detectVersion())->toBe('5.6.12');
        });
    });
});
