<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) php-team@yaochufa <php-team@yaochufa.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace a;

require_once '../src/string/StringUtil.php';

use phpLibrary\src\string\StringUtil;

$ret = StringUtil::uuid();

echo '<pre>';
print_r($ret);
