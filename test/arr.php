<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) php-team@yaochufa <php-team@yaochufa.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once '../src/arr/ArrayList.php';

use phpLibrary\src\arr\ArrayList;

$arrList = new ArrayList([1, 2, 3, 4, 5]);
$arrList->add(16);
$size    = $arrList->size();

var_dump($size);
