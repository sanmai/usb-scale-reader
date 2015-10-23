/*
 * For more information see:
 * http://www.usb.org/developers/hidpage/pos1_02.pdf
 *
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

enum report
{
    UNKNOWN_REPORT,
    /** Scale Attributes Report */
    ATTR,
    /** Scale Control Report */
    CONTROL,
    /** Scale Data Report */
    DATA,
    /** Scale Status Report */
    STATUS,
    /** Scale Weight Limit Report */
    LIMIT,
    /** Scale Statistics Report */
    STATS
};

enum status
{
    UNKNOWN_STATUS,
    /** Report fault */
    FAULT,
    /** Scale zero set */
    ZEROED,
    /** Weighing in progress */
    RETRY,
    /** Positive weight */
    POSITIVE,
    /** Negative weight */
    NEGATIVE,
    /** Over Weight */
    OVERLOAD,
    /** Calibration Needed */
    CALIBRATE,
    /** Re-zeroing Needed */
    REZERO
};

enum unit {
    UNKNOWN_UNIT, // unknown unit
    MILLIGRAM,
    GRAM,
    KILOGRAM,
    CARAT, // cd
    LIAN, // taels
    GRAIN, // gr
    PENNYWEIGHT, // dwt
    METRIC_TON, // tonnes
    AVOIR_TON, // tons
    TROY_OUNCE, // ozt
    OUNCE, // oz
    POUND // lbs
};
