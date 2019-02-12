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

if ($data->report === 0x03 && $data->status === 0x04) {
    $data->weight = $data->weight * pow(10, $data->exponent);
    if ($data->unit === 0x0B) {
        // convert ounces to grams
        $data->weight = round($data->weight * 28.349523125, 2);
        // and unit to grams
        $data->unit = 0x02;
    }

    if ($data->unit === 0x02) {
        fprintf(STDOUT, "%.2f g\n", $data->weight);
    } else {
        fprintf(STDOUT, "%.2f in other unit\n", $data->weight);
    }
}
