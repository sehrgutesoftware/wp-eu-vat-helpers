<?php

namespace SehrGut\WpPricesWithEuVat;

use Mockery;
use Mpociot\VatCalculator\VatCalculator;
use PHPUnit\Framework\TestCase;

function add_shortcode(...$args) {
    return PluginTest::$functions->add_shortcode(...$args);
}

function shortcode_atts(...$args) {
    return PluginTest::$functions->shortcode_atts(...$args);
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
     * @var VatCalculator
     */
    protected $vat_calculator;

    /** {@inheritdoc} */
    public function setUp()
    {
        // Prepare mocks
        $this->vat_calculator = Mockery::mock(VatCalculator::class);
        self::$functions = Mockery::mock();

        // Instantiate the plugin
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
            ->with('localize_currency', [$this->plugin, 'localizeCurrencyShortcode']);

        $this->plugin->registerShortcodes();
        $this->assertTrue(true);  // PHPUnit doesn't honor mock expectations as assertions
    }

    public function test_it_outputs_an_empty_string_if_no_value_is_given()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('getIPBasedCountry')->andReturn('DE');
        self::$functions->shouldReceive('shortcode_atts')
            ->andReturn(['value' => null]);

        // Perform the actual test
        $result = $this->plugin->localizeCurrencyShortcode();
        $this->assertEquals('', $result);
    }

    public function test_it_localizes_currencies()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('getIPBasedCountry')
            ->shouldReceive('calculate')->with(15, 'DE')->andReturn(17.85);
        self::$functions->shouldReceive('shortcode_atts')
            ->andReturn([
                'value' => 15,
                'currency' => 'EUR',
                'country' => 'DE'
            ]);

        // Perform the actual test
        $result = $this->plugin->localizeCurrencyShortcode(['value' => 15]);
        $this->assertEquals('17,85 €', $result);
    }
}
