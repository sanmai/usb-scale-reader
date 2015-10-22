<?php
/***
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

namespace USBScaleReader;

/**
 * Scale Status
 *
 * Documentation:
 * http://www.usb.org/developers/hidpage/
 * http://www.usb.org/developers/hidpage/pos1_02.pdf
 */

class Status
{
    /** Report fault */
    const FAULT      = 0x01;
    /** Scale zero set */
    const ZEROED     = 0x02;
    /** Weighing in progress */
    const RETRY      = 0x03;
    /** Positive weight */
    const POSITIVE   = 0x04;
    /** Negative weight */
    const NEGATIVE   = 0x05;
    /** Over Weight */
    const OVERLOAD   = 0x06;
    /** Calibration Needed */
    const CALIBRATE  = 0x07;
    /** Re-zeroing Needed */
    const REZERO     = 0x08;
}