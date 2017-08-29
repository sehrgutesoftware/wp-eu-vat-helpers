<?php

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
}
