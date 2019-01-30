<?php

/*
 * This file is part of PHP CS Fixer.
 */

namespace phpLibrary\src\file;

/**
 * 文件目录操作
 * Class FileSystem.
 */
class FileSystem
{
    /**
     * 遍历目录.
     *
     * @param $dir
     *
     * @return array
     */
    public function tree($dir)
    {
        $list = [];
        if (empty($dir)) {
            return $list;
        }
        foreach (glob($dir . '/*') as $id => $v) {
            $info                   = pathinfo($v);
            $list[$id]['path']      = $v;
            $list[$id]['type']      = filetype($v);
            $list[$id]['dirname']   = $info['dirname'];
            $list[$id]['basename']  = $info['basename'];
            $list[$id]['filename']  = $info['filename'];
            $list[$id]['extension'] = isset($info['extension']) ? $info['extension'] : '';
            $list[$id]['filemtime'] = filemtime($v);
            $list[$id]['fileatime'] = fileatime($v);
            $list[$id]['size']      = is_file($v) ? filesize($v) : $this->size($v);
            $list[$id]['iswrite']   = is_writable($v);
            $list[$id]['isread']    = is_readable($v);
        }

        return $list;
    }

    /**
     * 获取目录在小.
     *
     * @param $dir
     *
     * @return int
     */
    public function size($dir)
    {
        $s = 0;
        foreach (glob($dir . '/*') as $v) {
            $s += is_file($v) ? filesize($v) : self::size($v);
        }

        return $s;
    }

    /**
     * 删除文件.
     *
     * @param $file
     *
     * @return bool
     */
    public function delFile($file)
    {
        if (is_file($file)) {
            return unlink($file);
        }

        return true;
    }

    /**
     * 删除目录.
     *
     * @param string $dir 目录名
     *
     * @return bool
     */
    public function delDir($dir)
    {
        if (!is_dir($dir)) {
            return true;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delDir("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }

    /**
     * 创建目录.
     *
     * @param string $dir
     * @param int    $auth
     *
     * @return bool
     */
    public function createDir($dir, $auth = 0755)
    {
        if (!empty($dir)) {
            return is_dir($dir) or mkdir($dir, $auth, true);
        }
    }

    /**
     * 复制目录.
     *
     * @param $old
     * @param $new
     *
     * @return bool
     */
    public function copyDir($old, $new)
    {
        //is_dir($new) or mkdir($new, 0755, true);
        $this->createDir($new);
        foreach (glob($old . '/*') as $v) {
            $to = $new . '/' . basename($v);
            is_file($v) ? copy($v, $to) : $this->copyDir($v, $to);
        }

        return true;
    }

    /**
     * 复制文件.
     *
     * @param $file
     * @param $to
     *
     * @return bool
     */
    public function copyFile($file, $to)
    {
        if (!is_file($file)) {
            return false;
        }
        //创建目录
        $this->createDir(dirname($to));

        return copy($file, $to);
    }

    /**
     * 移动目录.
     *
     * @param $old
     * @param $new
     *
     * @return bool
     */
    public function moveDir($old, $new)
    {
        if ($this->copyDir($old, $new)) {
            return $this->delDir($old);
        }
    }

    /**
     * 移动文件.
     *
     * @param string $file 文件
     * @param string $dir  目录
     *
     * @return bool
     */
    public function moveFile($file, $dir)
    {
        //is_dir($dir) or mkdir($dir, 0755, true);
        $this->createDir($dir);
        if (is_file($file) && is_dir($dir)) {
            copy($file, $dir . '/' . basename($file));

            return unlink($file);
        }
    }

    /**
     * @param $file_name
     * @param string $open_mode
     * @param bool   $use_include_path
     * @param null   $context
     *
     * @return \SplFileObject
     */
    public function getSplFileObj($file_name, $open_mode = 'r', $use_include_path = false, $context = null)
    {
        try {
            return new \SplFileObject($file_name, $open_mode = 'r', $use_include_path = false, $context = null);
        } catch (\Exception $exception) {
            exit($exception->getMessage());
        }
    }
}
