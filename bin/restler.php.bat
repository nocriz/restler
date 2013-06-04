@ECHO OFF
SET BIN_TARGET=%~dp0\"../vendor/luracast/restler/vendor"\restler.php
php "%BIN_TARGET%" %*
