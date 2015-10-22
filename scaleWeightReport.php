<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */

/**
 * Class to parse weight data from a standard USB scale.
 *
 * Tested with:
 * - Stamps.com Stainless Steel 5 lb. Digital Scale
 * - DYMO M25 25 lb Digital Postal Scale
 */
class scaleWeightReport
{
    const REPORT_ID = 0x03;

    const STATUS_FAULT      = 0x01;
    const STATUS_ZEROED     = 0x02;
    const STATUS_RETRY      = 0x03; // Weighing in progress
    const STATUS_POSITIVE   = 0x04; // AKA success
    const STATUS_NEGATIVE   = 0x05; // Negative weight
    const STATUS_OVERLOAD   = 0x06; // Over Weight
    const STATUS_CALIBRATE  = 0x07; // Calibration Needed
    const STATUS_REZERO     = 0x08; // Re-zeroing Needed

    const UNIT_UNKNOWN      = 0; // unknown unit
    const UNIT_MILLIGRAM    = 1;
    const UNIT_GRAM         = 2;
    const UNIT_KILOGRAM     = 3;
    const UNIT_CARAT        = 4; // cd
    const UNIT_LIAN         = 5; // taels
    const UNIT_GRAIN        = 6; // gr
    const UNIT_PENNYWEIGHT  = 7; // dwt
    const UNIT_METRIC_TON   = 8; // tonnes
    const UNIT_AVOIR_TON    = 9; // tons
    const UNIT_TROY_OUNCE   = 10; // ozt
    const UNIT_OUNCE        = 11; // oz
    const UNIT_POUND        = 12; // lbs

    const OZ_IN_GRAMS = 28.349523125;

    public $report;
    public $status;
    public $unit;
    public $exponent;
    public $weight;

    public function __construct($data)
    {
        array_walk(unpack('Creport/Cstatus/Cunit/cexponent/vweight', $data), function ($value, $key) {
            $this->$key = $value;
        });

        if ($this->report != self::REPORT_ID || $this->status != self::STATUS_POSITIVE) {
            throw new Exception("Error reading scale data");
        }

        $this->weight = $this->weight * pow(10, $this->exponent);
    }

    public function __invoke()
    {
        switch ($this->unit) {
        	case self::UNIT_GRAM:
        	    return $this->weight;
        	case self::UNIT_OUNCE:
        	    return $this->weight * self::OZ_IN_GRAMS;
        	default:
        	    throw new Exception("Unknown unit");
        }
    }
}