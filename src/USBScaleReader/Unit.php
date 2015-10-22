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

class Unit
{
    const UNKNOWN      = 0; // unknown unit
    const MILLIGRAM    = 1;
    const GRAM         = 2;
    const KILOGRAM     = 3;
    const CARAT        = 4; // cd
    const LIAN         = 5; // taels
    const GRAIN        = 6; // gr
    const PENNYWEIGHT  = 7; // dwt
    const METRIC_TON   = 8; // tonnes
    const AVOIR_TON    = 9; // tons
    const TROY_OUNCE   = 10; // ozt
    const OUNCE        = 11; // oz
    const POUND        = 12; // lbs
}