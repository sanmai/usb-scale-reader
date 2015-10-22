# USBScaleReader

This library lets you read weight from a standard USB scale using pure PHP. 
 
Could be ported to other languages with ease, should they have `unpack()`
 
Tested with:
 - Stamps.com Stainless Steel 5 lb. Digital Scale
 - DYMO M25 25 lb Digital Postal Scale

See [read_stupid.php](example/read_stupid.php) if you want to understand how it works at a glance.

### Usage

    $reader = \USBScaleReader\Reader::fromDevice('/dev/scale');
    $weightInGrams = $reader->getWeight();
    var_dump($reader, $weightInGrams);

Sample output:

	class USBScaleReader\Reader#2 (5) {
	  public $report =>
	  int(3)
	  public $status =>
	  int(4)
	  public $unit =>
	  int(2)
	  public $exponent =>
	  int(0)
	  public $weight =>
	  int(144)
	}
	int(144)


### udev rules

Add to `/etc/udev/rules.d/80-persistent-scale.rules`:

    KERNEL=="hidraw*", ATTRS{manufacturer}=="Maker Name", SYMLINK+="scale"
    KERNEL=="hidraw*", SUBSYSTEM=="hidraw", MODE="0664", GROUP="plugdev"

Maker name is either `Stamps.com` or `DYMO`.

And then reconnect your scale.

For other makers see:

    udevadm info -a -p  $(udevadm info -q path -n /dev/hidrawN)

These rules imply that you should be in `plugdev` for the scripts to work.

 