<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../src/file/Archive.php';

use phpLibrary\src\file\Archive;

$archive = new Archive();

$ret = $archive->compress('./files/test.zip', './files');

var_dump($ret);
