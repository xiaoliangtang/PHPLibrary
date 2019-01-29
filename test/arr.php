<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../src/arr/ArrayList.php';

use phpLibrary\src\arr\ArrayList;

$arrList = new ArrayList([1, 2, 3, 4, 5]);
$arrList->add(16);
$size    = $arrList->size();

var_dump($size);
