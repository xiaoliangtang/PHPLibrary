<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../src/net/Curl.php';

use phpLibrary\src\net\Curl;

$curl = new Curl();

$url = 'http://www.baidu.com';
$ret = $curl->get($url);

//$status = $curl->isError();

var_dump($ret);
//echo $ret->response;
