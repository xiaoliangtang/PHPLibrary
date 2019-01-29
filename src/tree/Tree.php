<?php

/*
 * This file is part of PHP CS Fixer.
 */

namespace phpLibrary\src\tree;

class Tree
{
    /**
     * 生成树型结构所需要的2维数组.
     *
     * @var array
     */
    public $arr = [];

    /**
     * 生成树型结构所需修饰符号，可以换成图片.
     *
     * @var array
     */
    private $icon   = ['│', '├', '└'];
    private $nbsp   = '&nbsp;';
    private $config = [
        'id'       => 'id',
        'parentId' => 'parentId',
        'name'     => 'name',
        'child'    => 'child',
    ];

    /**
     * 构造函数，初始化类.
     *
     * @param array $arr    二维数组，例如：
     *                      array(
     *                      1 => array('id'=>'1','parentId'=>0,'name'=>'一级栏目一'),
     *                      2 => array('id'=>'2','parentId'=>0,'name'=>'一级栏目二'),
     *                      3 => array('id'=>'3','parentId'=>1,'name'=>'二级栏目一'),
     *                      4 => array('id'=>'4','parentId'=>1,'name'=>'二级栏目二'),
     *                      5 => array('id'=>'5','parentId'=>2,'name'=>'二级栏目三'),
     *                      6 => array('id'=>'6','parentId'=>3,'name'=>'三级栏目一'),
     *                      7 => array('id'=>'7','parentId'=>3,'name'=>'三级栏目二')
     *                      )
     * @param array $config 配置数组字段名称
     *
     * @return bool
     */
    public function __construct($arr = [], $config = [])
    {
        $this->arr = $arr;
        $this->ret = '';
        $this->str = '';
        if ($config) {
            $this->config = array_merge($this->config, $config);
        }

        return is_array($arr);
    }

    /**
     * 根据子类ID返回所有的父级.
     *
     * @param int $id
     *
     * @return array
     */
    public function getParents($id)
    {
        $ret          = [];
        $arr          = $this->arr;
        $idName       = $this->config['id'];
        $parentIdName = $this->config['parentId']; //父级id名称
        foreach ($arr as $v) {
            if ($v[$idName] == $id) {
                $ret[] = $v;
                $ret   = array_merge($this->getParents($v[$parentIdName]), $ret);
            }
        }

        return $ret;
    }

    /**
     * 根据父级ID返回所有的子类.
     *
     * @param int $parentId
     *
     * @return array
     */
    public function getChilds($parentId)
    {
        $ret          = [];
        $arr          = $this->arr;
        $idName       = $this->config['id'];
        $parentIdName = $this->config['parentId']; //父级id名称
        foreach ($arr as $v) {
            if ($v[$parentIdName] == $parentId) {
                $ret[] = $v;
                $ret   = array_merge($ret, $this->getChilds($v[$idName]));
            }
        }

        return $ret;
    }

    /**
     * 根据父级ID返回所有的子类（树形结构）.
     *
     * @param int $parentId
     *
     * @return array
     */
    public function getTree($parentId = 0)
    {
        $ret          = [];
        $arr          = $this->arr;
        $idName       = $this->config['id'];
        $parentIdName = $this->config['parentId']; //父级id名称
        $childName    = $this->config['child'];
        foreach ($arr as $v) {
            if ($v[$parentIdName] == $parentId) {
                $v[$childName] = $this->getTree($v[$idName]);
                $ret[]         = $v;
            }
        }

        return $ret;
    }

    /**
     * 组合一维数组.
     *
     * @param int $parentId
     * @param int $level
     *
     * @return array
     */
    public function unlimitedForLevel($parentId = 0, $level = 0)
    {
        $ret  = [];
        $arr  = $this->arr;
        $icon = $this->icon[2];
        foreach ($arr as $v) {
            if ($v['parentId'] == $parentId) {
                $v['level'] = $level + 1;
                $v['icon']  = str_repeat($this->nbsp, $level);
                if (0 != $parentId) {
                    $v['icon'] .= $icon;
                }
                $ret[]      = $v;
                //将子类合并到和父类的同一个数组里
                $ret = array_merge($ret, $this->unlimitedForLevel($v['id'], $level + 1));
            }
        }

        return $ret;
    }

    /**
     * 根据节点id获取父级数组的同级数组.
     *
     * @param int $id 节点id
     *
     * @return array
     */
    public function getParentsForSameLevel($id)
    {
        $ret = [];
        if (!isset($this->arr[$id])) {
            return [];
        }
        $parentIdName = $this->config['parentId']; //父级id名称
        $pid          = $this->arr[$id][$parentIdName]; //父级id
        $pid          = $this->arr[$pid][$parentIdName]; //祖级id
        if (is_array($this->arr)) {
            foreach ($this->arr as $key => $item) {
                if ($item[$parentIdName] == $pid) {
                    $ret[$key] = $item;
                }
            }
        }

        return $ret;
    }

    /**
     * 根据节点id获取子级数组的同级数组.
     *
     * @param int $id 节点id
     *
     * @return array
     */
    public function getChildsForSameLevel($id)
    {
        $ret = [];
        if (is_array($this->arr)) {
            foreach ($this->arr as $key => $item) {
                if ($item[$this->config['parentId']] == $id) {
                    $ret[$key] = $item;
                }
            }
        }

        return $ret;
    }
}
