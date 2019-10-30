@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phploc/phploc/phploc
php "%BIN_TARGET%" %*
