<?php
/**
 * Created by PhpStorm.
 * User: sunxiaozhi
 * Date: 2018/2/5
 * Time: 15:17
 */

/****************************************基本数据结构算法****************************************/
//二分查找（数组里查找某个元素）
function bin_sch($array, $low, $high, $k)
{
    if ($low <= $high) {
        $mid = intval(($low + $high) / 2);
        if ($array[$mid] == $k) {
            return $mid;
        } elseif ($k < $array[$mid]) {
            return bin_sch($array, $low, $mid - 1, $k);
        } else {
            return bin_sch($array, $mid + 1, $high, $k);
        }
    }
    return -1;
}

//顺序查找（数组里查找某个元素）
function seq_sch($array, $n, $k)
{
    $array[$n] = $k;
    for ($i = 0; $i < $n; $i++) {
        if ($array[$i] == $k) {
            break;
        }
    }
    if ($i < $n) {
        return $i;
    } else {
        return -1;
    }
}

//线性表的删除（数组中实现）
function delete_array_element($array, $i)
{
    $len = count($array);
    for ($j = $i; $j < $len; $j++) {
        $array[$j] = $array [$j + 1];
    }
    array_pop($array);
    return $array;
}

/****************************************PHP内置字符串函数实现****************************************/
//字符串长度
function strlen_realize($str)
{
    if ($str == '') return 0;
    $count = 0;
    while (1) {
        if ($str[$count] != NULL) {
            $count++;
            continue;
        } else {
            break;
        }
    }
    return $count;
}

//截取子串
function substr_realize($str, $start, $length = NULL)
{
    if ($str == '' || $start > strlen($str)) return '';
    if (($length != NULL) && ($start > 0) && ($length > strlen($str) - $start)) return '';
    if (($length != NULL) && ($start < 0) && ($length > strlen($str) + $start)) return '';
    if ($length == NULL) $length = (strlen($str) - $start);

    $substr = '';

    if ($start < 0) {
        for ($i = (strlen($str) + $start); $i < (strlen($str) + $start + $length); $i++) {
            $substr .= $str[$i];
        }
    }
    if ($length > 0) {
        for ($i = $start; $i < ($start + $length); $i++) {
            $substr .= $str[$i];
        }
    }
    if ($length < 0) {
        for ($i = $start; $i < (strlen($str) + $length); $i++) {
            $substr .= $str[$i];
        }
    }
    return $substr;
}

//字符串翻转
function strrev_realize($str)
{
    $rev_str = '';
    if ($str == '') return 0;
    for ($i = (strlen($str) - 1); $i >= 0; $i--) {
        $rev_str .= $str[$i];
    }
    return $rev_str;
}

//字符串比较
function strcmp_realize($s1, $s2)
{
    if (strlen($s1) < strlen($s2)) return -1;
    if (strlen($s1) > strlen($s2)) return 1;
    for ($i = 0; $i < strlen($s1); $i++) {
        if ($s1[$i] == $s2[$i]) {
            continue;
        } else {
            return false;
        }
    }
    return 0;
}

//查找字符串
function strstr_realize($str, $substr)
{
    $m = strlen($str);
    $n = strlen($substr);
    if ($m < $n) return false;
    for ($i = 0; $i <= ($m - $n + 1); $i++) {
        $sub = substr($str, $i, $n);
        if (strcmp($sub, $substr) == 0) return $i;
    }
    return false;
}

/****************************************自实现字符串处理函数****************************************/
//插入一段字符串
function str_insert($str, $i, $substr)
{
    $startstr = $laststr = '';

    for ($j = 0; $j < $i; $j++) {
        $startstr .= $str[$j];
    }

    for ($j = $i; $j < strlen($str); $j++) {
        $laststr .= $str[$j];
    }

    $str = ($startstr . $substr . $laststr);
    return $str;
}

//删除一段字符串
function str_delete($str, $i, $j)
{
    $startstr = $laststr = '';

    for ($c = 0; $c < $i; $c++) {
        $startstr .= $str [$c];
    }

    for ($c = ($i + $j); $c < strlen($str); $c++) {
        $laststr .= $str[$c];
    }
    $str = ($startstr . $laststr);
    return $str;
}

//复制字符串
function strcpy($s1, $s2)
{
    if (strlen($s1) == NULL || !isset($s2)) return '';
    for ($i = 0; $i < strlen($s1); $i++) {
        $s2[] = $s1 [$i];
    }
    return $s2;
}

//连接字符串
function strcat($s1, $s2)
{
    if (!isset($s1) || !isset($s2)) return '';
    $newstr = $s1;
    for ($i = 0; $i < count($s2); $i++) {
        $newstr .= $s2[$i];
    }
    return $newstr;
}

//简单加密函数（与php_decrypt函数对应）
function php_encrypt($str)
{
    $encrypt_key = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
    $enstr = '';
    if (strlen($str) == 0) return false;
    for ($i = 0; $i < strlen($str); $i++) {
        for ($j = 0; $j < strlen($encrypt_key); $j++) {
            if ($str[$i] == $encrypt_key [$j]) {
                $enstr .= $decrypt_key[$j];
                break;
            }
        }
    }
    return $enstr;
}

//简单解密函数（与php_encrypt函数对应）
function php_decrypt($str)
{
    $encrypt_key = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
    $enstr = '';
    if (strlen($str) == 0) return false;
    for ($i = 0; $i < strlen($str); $i++) {
        for ($j = 0; $j < strlen($decrypt_key); $j++) {
            if ($str[$i] == $decrypt_key [$j]) {
                $enstr .= $encrypt_key[$j];
                break;
            }
        }
    }
    return $enstr;
}

