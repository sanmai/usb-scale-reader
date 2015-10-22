<?php
/***
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

namespace USBScaleReader;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
    private function readerFromHex($hex)
    {
        return new Reader(hex2bin($hex));
    }

    public function testWeightInGrams()
    {
        $reader = $this->readerFromHex("030402006e0303");
        $this->assertEquals(878, $reader->getWeight());
    }

    public function testWeightInOunces()
    {
        $reader = $this->readerFromHex("03040bff4e0003");
        $this->assertEquals(221.126280375, $reader->getWeight());
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 1
     */
    public function testInvalidStatus()
    {
        $reader = $this->readerFromHex("03020bff000003");
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 1
     */
    public function testNegativeWeight()
    {
        $reader = $this->readerFromHex("03050bff000003");
    }

    /**
     * @expectedException USBScaleReader\Exception
     * @expectedExceptionCode 2
     */
    public function testUnknownUnit()
    {
        $reader = $this->readerFromHex("03040000900003");
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
