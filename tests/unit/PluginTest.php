<?php

namespace SehrGut\WpPricesWithEuVat;

use Mockery;
use Mpociot\VatCalculator\VatCalculator;
use PHPUnit_Framework_TestCase as TestCase;

function add_shortcode(...$args) {
    return PluginTest::$functions->add_shortcode(...$args);
}

class PluginTest extends TestCase
{
    /**
     * Holds a mock object for testing global functions.
     *
     * @var array
     */
    public static $functions;

    /**
     * Mock object for the VatCalculator
     * @var [type]
     */
    protected $vat_calculator;

    /** {@inheritdoc} */
    public function setUp()
    {
        self::$functions = Mockery::mock();
        $this->vat_calculator = Mockery::mock(VatCalculator::class);
        $this->plugin = new Plugin($this->vat_calculator);
    }

    /** {@inheritdoc} */
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_constructs_an_instance_of_the_plugin()
    {
        $this->assertTrue($this->plugin instanceof Plugin);
    }

    public function test_it_registers_shortcodes()
    {
        self::$functions->shouldReceive('add_shortcode')
            ->with('localize_price', [$this->plugin, 'localizePriceShortcode']);

        $this->plugin->registerShortcodes();
    }

    public function test_it_outputs_an_empty_string_if_no_value_is_given()
    {
        $result = $this->plugin->localizePriceShortcode();
        $this->assertEquals('', $result);
    }

    public function test_it_localizes_prices()
    {
        $this->vat_calculator
            ->shouldReceive('getIPBasedCountry')->andReturn('DE')
            ->shouldReceive('calculate')->with(15, 'DE')->andReturn(17.85);

        $result = $this->plugin->localizePriceShortcode(['value' => 15]);
        $this->assertEquals(17.85, $result);
    }
}
