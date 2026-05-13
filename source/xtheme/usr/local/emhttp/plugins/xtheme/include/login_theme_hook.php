<?php

$outputPath = '/boot/config/plugins/xtheme/login-theme.html';
if (is_file($outputPath) && is_readable($outputPath)) {
    @readfile($outputPath);
}
