#!/usr/bin/env sh
SRC_DIR="`pwd`"
cd "`dirname "$0"`"
cd "../vendor/luracast/restler/vendor"
BIN_TARGET="`pwd`/restler.php"
cd "$SRC_DIR"
"$BIN_TARGET" "$@"
