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
 * @covers \USBScaleReader\Reader
 */
class ReaderTest extends \PHPUnit\Framework\TestCase
{
    private function readerFromHex($hex)
    {
        return new Reader(hex2bin($hex));
    }

    public function testWeightInGrams()
    {
        $reader = $this->readerFromHex('030402006e03');
        $this->assertEquals(878, $reader->getWeight());
    }

    public function testWeightInOunces()
    {
        $reader = $this->readerFromHex('03040bff4e00');
        $this->assertEquals(221.126280375, $reader->getWeight());
    }

    public function testInvalidStatus()
    {
        $this->expectException(\USBScaleReader\Exception::class);
        $this->expectExceptionCode(1);

        $reader = $this->readerFromHex('03020bff0000');
    }

    public function testNegativeWeight()
    {
        $this->expectException(\USBScaleReader\Exception::class);
        $this->expectExceptionCode(1);

        $reader = $this->readerFromHex('03050bff0000');
    }

    public function testUnknownUnit()
    {
        $this->expectException(\USBScaleReader\Exception::class);
        $this->expectExceptionCode(2);

        $reader = $this->readerFromHex('030400009000');
        $reader->getWeight();
    }

    public function testUnreadableDevice()
    {
        $this->expectException(\USBScaleReader\Exception::class);
        $this->expectExceptionCode(3);

        Reader::fromDevice('');
    }
}
