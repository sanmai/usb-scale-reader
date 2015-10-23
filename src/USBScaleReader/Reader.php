<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */

namespace USBScaleReader;

/**
 * Class to parse weight data from a standard USB scale.
 *
 * Documentation:
 * http://www.usb.org/developers/hidpage/
 * http://www.usb.org/developers/hidpage/pos1_02.pdf
 */

class Reader
{
    const BYTES_TO_READ = 6;
    const OZ_IN_GRAMS = 28.349523125;

    public $report;
    public $status;
    public $unit;
    public $exponent;
    public $weight;

    public function __construct($data)
    {
        // we should account for different report lengths, but since we're lazy...
        foreach (unpack('Creport/Cstatus/Cunit/cexponent/vweight', $data) as $key => $value) {
            $this->$key = $value;
        }

        if ($this->report != Report::DATA || $this->status != Status::POSITIVE) {
            throw new Exception("Error reading scale data", Exception::READING_ERROR);
        }

        $this->weight = $this->weight * pow(10, $this->exponent);
    }

    public function getWeight()
    {
        switch ($this->unit) {
        	case Unit::GRAM:
        	    return $this->weight;
        	case Unit::OUNCE:
        	    return $this->weight * self::OZ_IN_GRAMS;
        	default:
        	    throw new Exception("Unknown unit", Exception::UNSUPPORTED_UNIT);
        }
    }

    /** @return /USBScaleReader/Reader */
    public static function fromDevice($deviceName = '/dev/scale')
    {
        if (!is_readable($deviceName)) {
            throw new Exception("Can't open scale device", Exception::UNREADABLE_DEVICE);
        }

        // read once to wake the scale up - may be not required
        fread(fopen($deviceName, 'rb'), self::BYTES_TO_READ);

        // load six bytes
        $binaryData = fread(fopen($deviceName, 'rb'), self::BYTES_TO_READ);

        return new self($binaryData);
    }
}