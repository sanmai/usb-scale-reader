<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */


$binary = fread(fopen('/dev/hidraw3', 'r'), 7);
$data = (object) unpack('Creport/Cstatus/Cunit/cexponent/vweight', $binary);

if ($data->report == 0x03 && $data->status == 0x04) {
    $data->weight = $data->weight * pow(10, $data->exponent);
    if ($data->unit == 0x0B) {
        // convert ounces to grams
        $data->weight *= 28.349523125;
        // and unit to grams
        $data->unit = 0x02;
    }

    if ($data->unit == 0x02) {
        echo "{$data->weight} g\n";
    } else {
        echo "{$data->weight} in other unit\n";
    }
}
