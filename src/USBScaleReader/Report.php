<?php
/***
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

namespace USBScaleReader;

/**
 * Scale Report Types
 *
 * Documentation:
 * http://www.usb.org/developers/hidpage/
 * http://www.usb.org/developers/hidpage/pos1_02.pdf (p.29, p.58)
 */

class Report
{
    /** Scale Attributes Report */
    const ATTR      = 1;
    /** Scale Control Report */
    const CONTROL   = 2;
    /** Scale Data Report */
    const DATA      = 3;
    /** Scale Status Report */
    const STATUS    = 4;
    /** Scale Weight Limit Report */
    const LIMIT     = 5;
    /** Scale Statistics Report */
    const STATS     = 6;
}
