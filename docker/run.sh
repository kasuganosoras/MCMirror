#!/bin/bash

trapIt () { "$@"& pid="$!"; trap "kill -INT $pid" INT TERM; while kill -0 $pid > /dev/null 2>&1; do wait $pid; ec="$?"; done; exit $ec;};

ARGS='--port 80 --host 0.0.0.0 --static-directory /workspace/public --app-env prod --debug 0'
trapIt /workspace/vendor/bin/ppm start --ansi $ARGS  $@