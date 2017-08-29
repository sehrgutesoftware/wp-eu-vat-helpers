<?php

namespace SehrGut\WpPricesWithEuVat;

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
        add_shortcode('localize_price', [$this, 'localizePriceShortcode']);

        return $this;
    }

    /**
     * Shortcode: Localize price based on user's IP address.
     *
     * @param  array  $attributes Attributes to the shortcode tag
     * @return string
     */
    public function localizePriceShortcode(array $attributes = [])
    {
        if (!array_key_exists('value', $attributes)) {
            return '';
        }

        $country_code = $this->vat_calculator->getIPBasedCountry();

        return $this->vat_calculator->calculate($attributes['value'], $country_code);
    }
}
