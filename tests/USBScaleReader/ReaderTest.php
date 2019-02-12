<?php
/***
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

namespace USBScaleReader;

class ReaderTest extends \PHPUnit\Framework\TestCase
{
    private function readerFromHex($hex)
    {
        return new Reader(hex2bin($hex));
    }

    public function testWeightInGrams()
    {
        $reader = $this->readerFromHex("030402006e03");
        $this->assertEquals(878, $reader->getWeight());
    }

    public function testWeightInOunces()
    {
        $reader = $this->readerFromHex("03040bff4e00");
        $this->assertEquals(221.126280375, $reader->getWeight());
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 1
     */
    public function testInvalidStatus()
    {
        $reader = $this->readerFromHex("03020bff0000");
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 1
     */
    public function testNegativeWeight()
    {
        $reader = $this->readerFromHex("03050bff0000");
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 2
     */
    public function testUnknownUnit()
    {
        $reader = $this->readerFromHex("030400009000");
        $reader->getWeight();
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 3
     */
    public function testUnreadableDevice()
    {
        Reader::fromDevice("");
    }
}
