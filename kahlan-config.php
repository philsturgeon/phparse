<?php 
use filter\Filter;
use VCR\VCR;

VCR::configure()->setCassettePath(__DIR__.'/spec/fixtures');
VCR::turnOn();

Filter::register('exclude.namespaces', function ($chain) {
});

Filter::apply($this, 'interceptor', 'exclude.namespaces');
