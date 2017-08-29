<?php

namespace SehrGut\WpPricesWithEuVat\Tests\Unit;

use Mpociot\VatCalculator\VatCalculator;
use SehrGut\WpPricesWithEuVat\Plugin;
use SehrGut\WpPricesWithEuVat\Tests\TestCase;

class PluginTest extends TestCase
{
    public function test_it_constructs_an_instance_of_the_plugin()
    {
        $plugin = new Plugin(new VatCalculator());

        $this->assertTrue($plugin instanceof Plugin);
    }
}
