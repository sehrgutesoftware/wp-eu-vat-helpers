# WordPress EU VAT Helpers

[![WordPress](https://img.shields.io/wordpress/v/wp-eu-vat-helpers.svg?style=flat-square)](https://wordpress.org/plugins/wp-eu-vat-helpers) [![Packagist](https://img.shields.io/packagist/v/sehrgut/wp-eu-vat-helpers.svg?style=flat-square)](https://packagist.org/packages/sehrgut/wp-eu-vat-helpers) [![Travis Build Status](https://img.shields.io/travis/sehrgutesoftware/wp-eu-vat-helpers/master.svg?style=flat-square)](https://travis-ci.org/sehrgutesoftware/wp-eu-vat-helpers) [![Codecov](https://img.shields.io/codecov/c/github/sehrgutesoftware/wp-eu-vat-helpers.svg?style=flat-square)](https://codecov.io/gh/sehrgutesoftware/wp-eu-vat-helpers) [![StyleCI Status](https://styleci.io/repos/66555789/shield)](https://styleci.io/repos/66555789)

> WordPress helper shortcodes to display prices including applicable VAT rate for the user's location (based on IP address)

This WordPress plugin is basically a wrapper around the nifty [mpociot/vat-calculator](https://github.com/mpociot/vat-calculator) library. Use at your own risk for the following:

- Format number as localized currency, adding VAT according to the rate of the visitor's country
- Display tax rate of the visitor's coutry
- Display the visitor's country
- Conditionally show/hide elements based on whether EU VAT is applicable in the visitor's country


## Installation

1. Recommended (most frequent updates): `composer require sehrgut/wp-eu-vat-helpers`
2. Alternative (possibly outdated): Via [WordPress plugin directory](https://wordpress.org/plugins/wp-eu-vat-helpers/) or zip download, you know that stuff for sure…


## Available Shortcodes

- [`[localize_currency]`](#localize_currency)
- [`[vat_rate]`](#vat_rate)
- [`[ip_country]`](#ip_country)
- [`[if_taxable] … [/if_taxable]`](#if_taxable)
- [`[unless_taxable] … [/unless_taxable]`](#unless_taxable)

### Shortcode Usage

---

#### [localize_currency]

> Add EU VAT to value and format the result as currency.

**Example:**
```
[localize_currency value="133.42" currency="EUR"]
```

**Attributes:**

| Attribute      | Required | Default       | Effect |
|----------------|----------|---------------|--------|
| `value`        | required | –             | The amount to format |
| `currency`     | optional | 'EUR'         | Currency as three-letter [ISO-4217](https://en.wikipedia.org/wiki/ISO_4217) code |
| `country`      | optional | based on user's IP address | Override the country for which to apply taxes and adapt the format (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code) |

---

#### [vat_rate]

> Display the EU VAT rate applicabe in the current user's country in percent.

**Example:**
```
[vat_rate]
```

**Attributes:**

| Attribute      | Required | Default       | Effect |
|----------------|----------|---------------|--------|
| `country`      | optional | based on user's IP address | Override the country whose VAT rate to display (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code) |

---

#### [ip_country]

> Display the current user's country based on their IP address.

**Example:**
```
[ip_country]
```

**Attributes:** none

---

#### [if_taxable]

> Condtitionally display a piece of content if EU VAT is applicable in the current user's country.

**Example:**
```
[if_taxable]Echo something[/if_taxable]
```

**Attributes:**

| Attribute      | Required | Default       | Effect |
|----------------|----------|---------------|--------|
| `country`      | optional | based on user's IP address | Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code) |

---

#### [unless_taxable]

> Condtitionally display a piece of content if EU VAT is *not* applicable in the current user's country. (Inverse of `if_taxable`)

**Example:**
```
[unless_taxable]Echo something[/unless_taxable]
```

**Attributes:**
| Attribute      | Required | Default       | Effect |
|----------------|----------|---------------|--------|
| `country`      | optional | based on user's IP address | Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code) |

## Devlopment / Testing

```bash
# Install
git clone git@github.com/sehrgutesoftware/wp-eu-vat-helpers.git
cd wp-eu-vat-helpers
composer install

# Test
composer unit
composer integration
```

## Support

Please use [Github Issues](https://github.com/sehrgutesoftware/wp-eu-vat-helpers/issues) for Questions, Bug reports, Feature suggestions and everything else.

## Compatibility

This plugin was tested with WordPress 4.8.x and PHP 7.1 & 7.2

## License

Copyright 2017 Sehr gute GmbH – licensed under the [MIT License](LICENSE.md).
