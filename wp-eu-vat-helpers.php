<?php
/*
Plugin Name:  WordPress EU VAT Helpers
Plugin URI:   https://github.com/sehrgutesoftware/wp-eu-vat-helpers
Description:  WordPress helper shortcodes to display prices including applicable VAT rate for the user's location (based on IP address)
Version:      1.1.2
Author:       sehrgute.software
Author URI:   https://sehrgute.software/
License:      MIT License
*/

namespace SehrGut\WpEuVatHelpers;

use Mpociot\VatCalculator\VatCalculator;

/*
 * Require Composer autoloader.
 */
if (file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    require_once $composer;
}

$plugin = new Plugin(new VatCalculator());
$plugin->registerShortcodes();
