<?php
function autoloader($className)
{
    $className = '..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}
spl_autoload_register('autoloader');