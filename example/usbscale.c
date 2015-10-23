/*
 * Simple standard USB scale reading program.
 *
 * Copyright (c) 2015 Alexey Kopytko
 * Released under the MIT license.
 */

#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <endian.h>
#include "usbscale.h"

struct data {
  enum report report;
  enum status status;
  enum unit unit;
  signed char exponent;
  unsigned short raw_weight; // 16 bit, little endian
  float weight;
};

int main(int argc, char** argv)
{
  if (argc < 2) {
    fprintf(stderr, "Usage: %s /dev/hidrawX\n", argv[0]);
    return 1;
  }

  FILE* fp = fopen(argv[1], "rb");
  if (fp == NULL) {
    fprintf(stderr, "Unable to open %s\n", argv[1]);
    return 1;
  }

  unsigned char buffer[6] = {0};
  fread(buffer, 1, sizeof(buffer), fp);
  fclose(fp);

  #ifdef DEBUG
  for (int i = 0; i < sizeof(buffer); i += 1) {
    printf("byte %i = %x\n", i, buffer[i]);
  }
  #endif

  struct data result;
  result.report = buffer[0];
  result.status = buffer[1];
  result.unit = buffer[2];
  result.exponent = buffer[3];
  // shall be little endian
  result.raw_weight =  le16toh(buffer[5] << 8 | buffer[4]);

  #ifdef DEBUG
  printf("report = %i\n", result.report);
  printf("status = %i\n", result.status);
  printf("unit = %i\n", result.unit);
  printf("exponent = %i\n", result.exponent);
  printf("raw weight = %i\n", result.raw_weight);
  #endif

  // Scale Data Report and Positive Weight Status
  if (result.report == DATA && result.status == POSITIVE) {
    // ...the scaling applied to the data as a base ten exponent
    result.weight = result.raw_weight * pow(10, result.exponent);
    if (result.unit == OUNCE) {
      // convert ounces to grams
      result.weight *= 28.349523125;
      // and change unit to grams
      result.unit = GRAM;
    }

    if (result.unit == GRAM) {
      printf("%.2f g\n", result.weight);
    } else {
      printf("%.2f in other unit\n", result.weight);
    }
  }

  return 0;
}
