<?php
$autoloadConfig = require_once __DIR__.'/../config/autoload.php';

spl_autoload_register(function($className) use ($autoloadConfig) {
    $path = explode("\\", $className);
    $dir = array_shift($path);
    $dir = $autoloadConfig['aliases'][$dir] ?? $dir;

    require_once __DIR__.'/../'.$dir.DIRECTORY_SEPARATOR.join(DIRECTORY_SEPARATOR, $path).'.php';
});