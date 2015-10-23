<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */

if (empty($argv[1])) {
    echo "Usage: DEBUG=1 php $argv[0] /dev/hidrawX\n";
    return;
}

$binary = fread(fopen($argv[1], 'r'), 6);

if (isset($_SERVER['DEBUG'])) {
    $dataHex = bin2hex($binary);
    echo "Data: $dataHex\n";
    file_put_contents("$dataHex.bin", $binary);
}

$data = (object) unpack('Creport/Cstatus/Cunit/cexponent/vweight', $binary);

if ($data->report == 0x03 && $data->status == 0x04) {
    $data->weight = $data->weight * pow(10, $data->exponent);
    if ($data->unit == 0x0B) {
        // convert ounces to grams
        $data->weight = round($data->weight * 28.349523125, 2);
        // and unit to grams
        $data->unit = 0x02;
    }

    if ($data->unit == 0x02) {
        fprintf(STDOUT, "%.2f g\n", $data->weight);
    } else {
        fprintf(STDOUT, "%.2f in other unit\n", $data->weight);
    }
}
