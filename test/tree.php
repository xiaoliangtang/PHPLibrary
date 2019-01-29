<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) php-team@yaochufa <php-team@yaochufa.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once '../src/tree/Tree.php';
use phpLibrary\src\tree\Tree;

$cate = [
    1 => ['id'=>'1', 'parentId'=>0, 'name'=>'一级栏目一'],
    2 => ['id'=>'2', 'parentId'=>0, 'name'=>'一级栏目二'],
    3 => ['id'=>'3', 'parentId'=>1, 'name'=>'二级栏目一'],
    4 => ['id'=>'4', 'parentId'=>1, 'name'=>'二级栏目二'],
    5 => ['id'=>'5', 'parentId'=>2, 'name'=>'二级栏目三'],
    6 => ['id'=>'6', 'parentId'=>3, 'name'=>'三级栏目一'],
    7 => ['id'=>'7', 'parentId'=>3, 'name'=>'三级栏目二'],
];
$tree    = new Tree($cate);
$parents = $tree->getParents(7);
$ret     = $tree->getTree(0);
$ret     = $tree->getParentsForSameLevel(7);
$ret     = $tree->getChildsForSameLevel(1);
$ret     = $tree->getChilds(3);
$ret     = $tree->unlimitedForLevel();

echo '<pre>';
//print_r($parents);
print_r($ret);
