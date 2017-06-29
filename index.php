<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/vendor/autoload.php';

use Folleah\Sharedder\SharedMemory;

$shMemory = new SharedMemory;

$shMemory->set('exampleIdentifier', 'Hello ');
echo $shMemory->get('exampleIdntifier');
/*
$shMemory->modify('someIdentifier', 'World!', $shMemory->size('someIdentifier'));
echo $shMemory->get('someIdentifier');
*/