<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$path = realpath(__DIR__);

$objects = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
$autloadPaths=array();
foreach ($objects as $name => $object) {
    if ($object->getFilename() === 'composer.json') {
        $file = $object->getPathname();

        if (!is_readable($file)) {
            chmod($file, 0777);
        }

        $string = file_get_contents($file);
        $json = (array) json_decode($string, true);

        if (isset($json['autoload']) && is_array($json['autoload'])) {


            $autoload = $autoloadKey = array_pop($json['autoload']);

            if (!is_array($autoload) && count($autoload))
                continue;
            
            //Fetch the array Key
            $key = array_pop(array_flip($autoloadKey));
            $key = substr($key, 0, strpos($key, '\\'));

            //Fetch the path 
            $last_occurence = strrpos($file, '/');
            $fileLength = strlen($file);
            $last = $last_occurence - $fileLength - 2;
            $prevOccurence = strrpos($file, '/', $last);
            
            //prev occurence
            $currentDir = substr($file, $prevOccurence, $last_occurence - $prevOccurence);
            $composerPath = array_pop($autoload);

            if (strlen($composerPath)) {
                $autloadPaths[$key] = $currentDir . '/' . substr($composerPath, 0, strrpos($composerPath, '/') + 1);
            } else {
                $autloadPaths[$key] = $currentDir . '/';
            }
            echo ".....\n";
        } else continue;
    }
}

$fileToWrite = __DIR__ . '/autoload.json';

if (!file_exists($fileToWrite)) {
    exec("touch " . $fileToWrite);
}
if (!is_writable($fileToWrite))
    chmod($fileToWrite, '0777');

if (!file_put_contents($fileToWrite, json_encode($autloadPaths)))
    echo "Please check the directory for write permission\n";
else
    echo "OK\n";
