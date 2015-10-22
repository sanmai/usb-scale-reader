<?php
/*
 * © 2015 Alexey Kopytko <alexey@kopytko.ru>
 * Distributed under the MIT License.
 */

namespace USBScaleReader;

class Exception extends \Exception
{
    const READING_ERROR = 1;
    const UNSUPPORTED_UNIT = 2;
    const UNREADABLE_DEVICE = 3;
}
