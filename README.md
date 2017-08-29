# Prices with EU VAT
> A WordPress helper shortcode to display prices including applicable VAT rate for the user's location (based on IP address)

This WordPress plugin is basically a wrapper around the nifty [mpociot/vat-calculator](https://github.com/mpociot/vat-calculator) library. Use at your own risk!

## Installation

…

## Shortcode Usage

### `[localize_currency value="133.42" currency="EUR"]`
Add EU VAT to value and format the result as a currency.
#### Attributes:
- `value` (required): The amount to format
- `currency` (optional, default: 'EUR'): Currency format as three-letter [ISO-4217](https://en.wikipedia.org/wiki/ISO_4217) code
- `country` (optional, default by user's IP address): Override the country for which to apply taxes and adapt the format (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

### `[if_taxable]Echo something[/if_taxable]`
Condtitionally display a piece of content if EU VAT is applicable in the current user's country.
#### Attributes:
- `country` (optional, default by user's IP address): Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)

### `[unless_taxable]Echo something[/unless_taxable]`
Condtitionally display a piece of content if EU VAT is *not* applicable in the current user's country. (Inverse of `if_taxable`)
#### Attributes:
- `country` (optional, default by user's IP address): Override the country for which to check (two-letter [ISO-3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) code)


## License

Copyright 2017 Sehr gute GmbH – licensed under the [MIT License](LICENSE.md).
