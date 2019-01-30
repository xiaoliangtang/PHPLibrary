<?php

/*
 * This file is part of PHP CS Fixer.
 */

use phpLibrary\src\file\FileSystem;

require_once '../src/file/FileSystem.php';

$file       = './files/test.zip';
$fileSystem = new FileSystem();
$splFileObj = $fileSystem->getSplFileObj($file);
$pathInfo   = $splFileObj->getPathInfo();
$tree       = $fileSystem->tree('./files');

echo '<pre>';
print_r($pathInfo);
print_r($tree);
