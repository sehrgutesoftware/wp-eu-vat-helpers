<?php

namespace SehrGut\WpEuVatHelpers;

use Mockery;
use Mpociot\VatCalculator\VatCalculator;
use PHPUnit\Framework\TestCase;

function add_shortcode(...$args)
{
    return PluginTest::$functions->add_shortcode(...$args);
}

function shortcode_atts(...$args)
{
    return PluginTest::$functions->shortcode_atts(...$args);
}

function do_shortcode(...$args)
{
    return PluginTest::$functions->do_shortcode(...$args);
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
     * Mock object for the VatCalculator.
     *
     * @var VatCalculator
     */
    protected $vat_calculator;

    /** {@inheritdoc} */
    public function setUp()
    {
        // Prepare mocks
        $this->vat_calculator = Mockery::mock(VatCalculator::class);
        $this->vat_calculator->shouldReceive('getIPBasedCountry')->andReturn('something');

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
        self::$functions->shouldReceive('add_shortcode')->once()
            ->with('localize_currency', [$this->plugin, 'localizeCurrencyShortcode']);
        self::$functions->shouldReceive('add_shortcode')->once()
            ->with('if_taxable', [$this->plugin, 'ifTaxableShortcode']);
        self::$functions->shouldReceive('add_shortcode')->once()
            ->with('unless_taxable', [$this->plugin, 'unlessTaxableShortcode']);
        self::$functions->shouldReceive('add_shortcode')->once()
            ->with('vat_rate', [$this->plugin, 'vatRateShortcode']);
        self::$functions->shouldReceive('add_shortcode')->once()
            ->with('ip_country', [$this->plugin, 'ipCountryShortcode']);

        $this->plugin->registerShortcodes();
        $this->assertTrue(true);  // PHPUnit doesn't honor mock expectations as assertions
    }

    public function test_it_outputs_an_empty_string_if_no_value_is_given()
    {
        // Setup mocks
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
            ->shouldReceive('calculate')->with(15, 'DE')->andReturn(17.85);
        self::$functions->shouldReceive('shortcode_atts')
            ->andReturn([
                'value'    => 15,
                'currency' => 'EUR',
                'country'  => 'DE',
            ]);

        // Perform the actual test
        $result = $this->plugin->localizeCurrencyShortcode(['value' => 15]);
        $this->assertEquals('17,85 €', $result);
    }

    public function test_if_taxable_displays_body_if_vat_applicable()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('shouldCollectVAT')->with('something')->andReturn(true);
        self::$functions
            ->shouldReceive('shortcode_atts')->andReturn(['country' => 'something'])
            ->shouldReceive('do_shortcode')->andReturn('display me');

        // Perform the actual test
        $result = $this->plugin->ifTaxableShortcode([], 'display me');
        $this->assertEquals('display me', $result);
    }

    public function test_if_taxable_swallows_body_if_vat_not_applicable()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('shouldCollectVAT')->with('something')->andReturn(false);
        self::$functions
            ->shouldReceive('shortcode_atts')->andReturn(['country' => 'something']);

        // Perform the actual test
        $result = $this->plugin->ifTaxableShortcode([], 'dont display me');
        $this->assertEquals('', $result);
    }

    public function test_unless_taxable_swallows_body_if_vat_applicable()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('shouldCollectVAT')->with('something')->andReturn(false);
        self::$functions
            ->shouldReceive('shortcode_atts')->andReturn(['country' => 'something'])
            ->shouldReceive('do_shortcode')->andReturn('display me');

        // Perform the actual test
        $result = $this->plugin->unlessTaxableShortcode([], 'display me');
        $this->assertEquals('display me', $result);
    }

    public function test_unless_taxable_displays_body_if_no_vat_applicable()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('shouldCollectVAT')->with('something')->andReturn(true);
        self::$functions
            ->shouldReceive('shortcode_atts')->andReturn(['country' => 'something']);

        // Perform the actual test
        $result = $this->plugin->unlessTaxableShortcode([], 'dont display me');
        $this->assertEquals('', $result);
    }

    public function test_it_outputs_current_tax_rate()
    {
        // Setup mocks
        $this->vat_calculator
            ->shouldReceive('getTaxRateForLocation')->with('DE')->andReturn(0.19);
        self::$functions->shouldReceive('shortcode_atts')
            ->andReturn([
                'country' => 'DE',
            ]);

        // Perform the actual test
        $result = $this->plugin->vatRateShortcode();
        $this->assertEquals('19', $result);
    }

    public function test_it_outputs_current_country_based_on_ip()
    {
        // Perform the actual test
        $result = $this->plugin->ipCountryShortcode();
        $this->assertEquals('something', $result);
    }
}
