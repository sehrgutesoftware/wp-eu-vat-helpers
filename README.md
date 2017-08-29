# Prices with EU VAT
> A WordPress helper shortcode to display prices including applicable VAT rate for the user's location (based on IP address)

## Installation

## Usage

### `[localize_currency value="133.42" currency="EUR"]`

Add EU VAT to value and format the result as a currency.

#### Attributes:

- `value` (required): The amount to format
- `currency` (optional, default: 'EUR'): Currency format as three-letter [ISO-4217](https://en.wikipedia.org/wiki/ISO_4217) code
- `country` (optional, default by user's IP address): Override the country for which to apply taxes and adapt the format (two-letter country code)

## License

Copyright 2017 Sehr gute GmbH – licensed under the [MIT License](LICENSE.md).
