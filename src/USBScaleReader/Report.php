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
 * Scale Report Types.
 *
 * Documentation:
 * http://www.usb.org/developers/hidpage/
 * http://www.usb.org/developers/hidpage/pos1_02.pdf (p.29, p.58)
 */
class Report
{
    /** Scale Attributes Report */
    const ATTR = 1;
    /** Scale Control Report */
    const CONTROL = 2;
    /** Scale Data Report */
    const DATA = 3;
    /** Scale Status Report */
    const STATUS = 4;
    /** Scale Weight Limit Report */
    const LIMIT = 5;
    /** Scale Statistics Report */
    const STATS = 6;
}
