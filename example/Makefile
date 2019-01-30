SHELL=/bin/bash
CFLAGS=
LDFLAGS=-lm

all: usbscale

debug: CFLAGS += -DDEBUG -g
debug: clean usbscale

usbscale: usbscale.c usbscale.h
	gcc -o usbscale $(CFLAGS) usbscale.c $(LDFLAGS)

clean:
	rm usbscale

test: usbscale
	@for i in tests/*; do if ! diff -y -W80 --suppress-common-lines <(php read_stupid.php $$i) <(./usbscale $$i); then echo "$$i failed"; fi; done
