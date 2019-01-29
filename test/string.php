<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../src/string/StringUtil.php';

use phpLibrary\src\string\StringUtil;

$ret = StringUtil::uuid();

echo '<pre>';
print_r($ret);
