<?php
/**
 * This code is licensed under the MIT License. (MIT)
 *
 * Copyright (c) 2014-2015 Alexey Kopytko
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

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
            $this->{$key} = $value;
        }

        if ($this->report !== Report::DATA || $this->status !== Status::POSITIVE) {
            throw new Exception('Error reading scale data', Exception::READING_ERROR);
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
                throw new Exception('Unknown unit', Exception::UNSUPPORTED_UNIT);
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
