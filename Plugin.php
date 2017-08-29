<?php

namespace SehrGut\WpEuVatHelpers;

use Mpociot\VatCalculator\VatCalculator;
use NumberFormatter;

class Plugin
{
    /**
     * An instance of the VatCalculator that does all the actual processing.
     *
     * @var VatCalculator
     */
    protected $vat_calculator;

    /**
     * Cached country code of the user based on their IP.
     *
     * @var string
     */
    protected $ip_country;

    /**
     * Construct a new instance of the plugin.
     *
     * @param VatCalculator $vat_calculator
     */
    public function __construct(VatCalculator $vat_calculator)
    {
        $this->vat_calculator = $vat_calculator;
        $this->ip_country = $this->vat_calculator->getIPBasedCountry();
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
        add_shortcode('ip_country', [$this, 'ipCountryShortcode']);

        return $this;
    }

    /**
     * Shortcode: Localize price based on user's IP address.
     *
     * @param array $attributes Attributes to the shortcode tag
     *
     * @return string
     */
    public function localizeCurrencyShortcode($attributes = [])
    {
        $attributes = shortcode_atts([
            'value'    => null,
            'country'  => $this->ip_country,
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
     * @param array $attributes Attributes to the shortcode tag
     *
     * @return string
     */
    public function ifTaxableShortcode($attributes, string $body)
    {
        $attributes = shortcode_atts([
            'country' => $this->ip_country,
        ], $attributes);

        if ($this->vat_calculator->shouldCollectVat($attributes['country'])) {
            return do_shortcode($body);
        }

        return '';
    }

    /**
     * Shortcode: Show body only if *no* EU VAT is applicable in given country.
     *
     * @param array $attributes Attributes to the shortcode tag
     *
     * @return string
     */
    public function unlessTaxableShortcode($attributes, string $body)
    {
        $attributes = shortcode_atts([
            'country' => $this->ip_country,
        ], $attributes);

        if ($this->vat_calculator->shouldCollectVat($attributes['country'])) {
            return '';
        }

        return do_shortcode($body);
    }

    /**
     * Return the current VAT rate based on the user's country.
     *
     * @param array $attributes Attributes to the shortcode tag
     *
     * @return string
     */
    public function vatRateShortcode($attributes = [])
    {
        $attributes = shortcode_atts([
            'country' => $this->ip_country,
        ], $attributes);

        return (string) $this->vat_calculator->getTaxRateForLocation($attributes['country']) * 100;
    }

    /**
     * Return the current user's country based on their IP address.
     *
     * @param array $attributes Attributes to the shortcode tag
     *
     * @return string
     */
    public function ipCountryShortcode($attributes = [])
    {
        return $this->ip_country;
    }

    /**
     * Return a NumberFormatter instance for given country.
     *
     * @param string $country two-letter country code
     *
     * @return NumberFormatter
     */
    protected function makeFormatter(string $country)
    {
        return new NumberFormatter($country, NumberFormatter::CURRENCY);
    }
}
