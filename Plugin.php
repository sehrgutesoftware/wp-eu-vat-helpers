<?php

namespace SehrGut\WpEuVatHelpers;

use NumberFormatter;
use Mpociot\VatCalculator\VatCalculator;

class Plugin
{
    /**
     * An instance of the VatCalculator that does all the actual processing.
     *
     * @var VatCalculator
     */
    protected $vat_calculator;

    /**
     * Construct a new instance of the plugin.
     *
     * @param VatCalculator $vat_calculator
     */
    public function __construct(VatCalculator $vat_calculator)
    {
        $this->vat_calculator = $vat_calculator;
    }

    /**
     * Register all shortcodes.
     *
     * @return $this
     */
    public function registerShortcodes()
    {
        add_shortcode('localize_currency', [$this, 'localizeCurrencyShortcode']);
        add_shortcode('if_taxable', [$this, 'ifTaxableShortcode']);
        add_shortcode('unless_taxable', [$this, 'unlessTaxableShortcode']);
        add_shortcode('vat_rate', [$this, 'vatRateShortcode']);

        return $this;
    }

    /**
     * Shortcode: Localize price based on user's IP address.
     *
     * @param  array  $attributes Attributes to the shortcode tag
     * @return string
     */
    public function localizeCurrencyShortcode($attributes = [])
    {
        $attributes = shortcode_atts([
            'value' => null,
            'country' => $this->vat_calculator->getIPBasedCountry(),
            'currency' => 'EUR',
        ], $attributes);

        if (is_null($attributes['value'])) {
            return '';
        }

        $gross = $this->vat_calculator->calculate($attributes['value'], $attributes['country']);
        $formatter = $this->makeFormatter($attributes['country']);

        return $formatter->formatCurrency($gross, $attributes['currency']);
    }

    /**
     * Shortcode: Show body if EU VAT is applicable in given country.
     *
     * @param  array  $attributes Attributes to the shortcode tag
     * @return string
     */
    public function ifTaxableShortcode($attributes = [], string $body)
    {
        $attributes = shortcode_atts([
            'country' => $this->vat_calculator->getIPBasedCountry(),
        ], $attributes);

        if ($this->vat_calculator->shouldCollectVat($attributes['country'])) {
            return do_shortcode($body);
        }

        return '';
    }

    /**
     * Shortcode: Show body only if *no* EU VAT is applicable in given country.
     *
     * @param  array  $attributes Attributes to the shortcode tag
     * @return string
     */
    public function unlessTaxableShortcode($attributes = [], string $body)
    {
        $attributes = shortcode_atts([
            'country' => $this->vat_calculator->getIPBasedCountry(),
        ], $attributes);

        if ($this->vat_calculator->shouldCollectVat($attributes['country'])) {
            return '';
        }

        return do_shortcode($body);
    }

    /**
     * Return the current VAT rate based on the user's country.
     *
     * @param  array  $attributes Attributes to the shortcode tag
     * @return string
     */
    public function vatRateShortcode($attributes = [])
    {
        $attributes = shortcode_atts([
            'country' => $this->vat_calculator->getIPBasedCountry(),
        ], $attributes);

        return (string) $this->vat_calculator->getTaxRateForLocation($attributes['country']) * 100;
    }

    /**
     * Return a NumberFormatter instance for given country.
     *
     * @param  string $country two-letter country code
     * @return NumberFormatter
     */
    protected function makeFormatter(string $country)
    {
        return new NumberFormatter($country, NumberFormatter::CURRENCY);
    }
}
