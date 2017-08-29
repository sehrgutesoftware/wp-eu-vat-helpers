<?php
/*
Plugin Name:  Prices with EU VAT
Plugin URI:   https://github.com/sehrgutesoftware/wp-prices-with-eu-vat
Description:  A WordPress helper shortcode to display prices including applicable VAT rate for the user's location (based on IP address)
Version:      1.0.0
Author:       sehrgute.software
Author URI:   https://sehrgute.software/
License:      MIT License
*/

namespace SehrGut\WpPricesWithEuVat;

use Mpociot\VatCalculator\VatCalculator;
use SehrGut\WpPricesWithEuVat\Plugin;

/**
 * Require Composer autoloader.
 */
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  require_once $composer;
}

$plugin = new Plugin(new VatCalculator());
$plugin->registerShortcodes();
