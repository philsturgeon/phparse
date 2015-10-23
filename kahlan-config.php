<?php 
use filter\Filter;
use VCR\VCR;

VCR::configure()->setCassettePath('spec/fixtures');
VCR::turnOn();

Filter::register('exclude.namespaces', function ($chain) {
    $defaults = ['VCR', 'Assert'];
    $excluded = $this->args()->get('exclude');
    $this->args()->set('exclude', array_unique(array_merge($excluded, $defaults)));
    return $chain->next();
});

Filter::apply($this, 'interceptor', 'exclude.namespaces');
