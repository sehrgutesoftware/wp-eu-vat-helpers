=== WordPress EU VAT Helpers ===
Contributors: jsphpl
Tags: currency, localization, eu, vat, value added tax, ust, mehrwertsteuer, tax
Requires at least: 4.8
Tested up to: 4.8.1
Stable tag: 1.1.1
License: MIT
License URI: https://github.com/sehrgutesoftware/wp-eu-vat-helpers/blob/master/LICENSE.md

WordPress helper shortcodes to display prices including applicable VAT rate for the user's location (based on IP address)

== Description ==

[![Packagist](https://img.shields.io/packagist/v/sehrgut/wp-eu-vat-helpers.svg?style=flat-square)](https://packagist.org/packages/sehrgut/wp-eu-vat-helpers) [![Travis Build Status](https://img.shields.io/travis/sehrgutesoftware/wp-eu-vat-helpers/master.svg?style=flat-square)](https://travis-ci.org/sehrgutesoftware/wp-eu-vat-helpers) [![Codecov](https://img.shields.io/codecov/c/github/sehrgutesoftware/wp-eu-vat-helpers.svg?style=flat-square)](https://codecov.io/gh/sehrgutesoftware/wp-eu-vat-helpers) [![StyleCI Status](https://styleci.io/repos/66555789/shield)](https://styleci.io/repos/66555789)

This WordPress plugin is basically a wrapper around the nifty [mpociot/vat-calculator](https://github.com/mpociot/vat-calculator) library. Use at your own risk!

### Shortcode Usage

#### `[localize_currency value="133.42" currency="EUR"]`
Add EU VAT to value and format the result as a currency.
##### Attributes:
- `value` (required): The amount to format
- `currency` (optional, default: 'EUR'): Currency format as three-letter [ISO-4217](https://en.wikipedia.org/wiki/ISO_4217) code
- `country` (optional, default by user's IP address): Override the country for which to apply taxes and adapt the format (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

#### `[vat_rate]`
Display the EU VAT rate applicabe in the current user's country in percent.
##### Attributes:
- `country` (optional, default by user's IP address): Override the country whose VAT rate to display (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

#### `[ip_country]`
Display the current user's country based on their IP address.

#### `[if_taxable]Echo something[/if_taxable]`
Condtitionally display a piece of content if EU VAT is applicable in the current user's country.
##### Attributes:
- `country` (optional, default by user's IP address): Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

#### `[unless_taxable]Echo something[/unless_taxable]`
Condtitionally display a piece of content if EU VAT is *not* applicable in the current user's country. (Inverse of `if_taxable`)
##### Attributes:
- `country` (optional, default by user's IP address): Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the `wp-eu-vat-helpers` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.1.1 =
* Fix performance related to geo-ip lookups

= 1.1.0 =
* Add `ip_country` shortcode

= 1.0.0 =
* Initial Release
