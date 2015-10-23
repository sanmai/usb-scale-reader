<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */

if (empty($argv[1])) {
    echo "Usage: php $argv[0] /dev/hidrawX\n";
    return;
}

$binary = fread(fopen($argv[1], 'r'), 6);

$dataHex = bin2hex($binary);
echo "Data: $dataHex\n";

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
