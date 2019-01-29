<?php
require_once '../src/file/Archive.php';

use phpLibrary\src\file\Archive;

$archive = new Archive();

$ret = $archive->compress('./files/test.zip', './files');

var_dump($ret);