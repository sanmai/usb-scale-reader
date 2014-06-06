<?php
/***
 * Copyright (c) 2014 Alexey Kopytko
 * Released under the MIT license.
 */

include 'scaleWeightReport.php';

/**
 * Add to /etc/udev/rules.d/80-persistent-scale.rules:
 * KERNEL=="hidraw*", ATTRS{manufacturer}=="Stamps.com", MODE="0644", SYMLINK+="scale"
 *
 * And then reconnect your scale.
 *
 * For other makers see:
 * udevadm info -a -p  $(udevadm info -q path -n /dev/hidrawN)
 */

const SCALE = '/dev/scale';

if (!is_readable(SCALE)) {
    echo "Can't open scale device.\n";
    return;
}

// read once to wake the scale up - may be not required
fread(fopen(SCALE, 'rb'), 7);

// load seven bytes
$binaryData = fread(fopen(SCALE, 'rb'), 7);

$report = new scaleWeightReport($binaryData);

// invoke as a function
$weightInGrams = $report();

var_dump($report, $weightInGrams);

/*
Sample output:

class scaleWeightReport#1 (5) {
  public $report =>
  int(3)
  public $status =>
  int(4)
  public $unit =>
  int(11)
  public $exponent =>
  int(-1)
  public $weight =>
  double(0.6)
}
double(17.009713875)

*/