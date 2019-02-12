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
 * Scale Status.
 *
 * Documentation:
 * http://www.usb.org/developers/hidpage/
 * http://www.usb.org/developers/hidpage/pos1_02.pdf
 */
class Unit
{
    const UNKNOWN = 0; // unknown unit
    const MILLIGRAM = 1;
    const GRAM = 2;
    const KILOGRAM = 3;
    const CARAT = 4; // cd
    const LIAN = 5; // taels
    const GRAIN = 6; // gr
    const PENNYWEIGHT = 7; // dwt
    const METRIC_TON = 8; // tonnes
    const AVOIR_TON = 9; // tons
    const TROY_OUNCE = 10; // ozt 0x0a
    const OUNCE = 11; // oz 0x0b
    const POUND = 12; // lbs 0x0c
}
