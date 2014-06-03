<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$fileToWrite = __DIR__ . '/autoload.json';
$pathString = file_get_contents($fileToWrite);
$paths = (array) json_decode($pathString);

//autoloader fucntion to register
function my_autoload($pClassName) {
    global $paths;
    $nsKey = substr($pClassName, 0, strpos($pClassName, '\\'));
    require_once(__DIR__.'/Vendor' . $paths[$nsKey] . str_replace('\\', '/', $pClassName) . '.php');
}

spl_autoload_register('my_autoload');
