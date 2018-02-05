<?php
/**
 * Created by PhpStorm.
 * User: sunxiaozhi
 * Date: 2018/2/5
 * Time: 15:17
 */

//--------------------
// 基本数据结构算法
//--------------------
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

//冒泡排序（数组排序）
function bubble_sort($array)
{
    $count = count($array);
    if ($count <= 0) return false;
    for ($i = 0; $i < $count; $i++) {
        for ($j = $count - 1; $j > $i; $j--) {
            if ($array[$j] < $array [$j - 1]) {
                $tmp = $array[$j];
                $array[$j] = $array[$j - 1];
                $array [$j - 1] = $tmp;
            }
        }
    }
    return $array;
}

//快速排序（数组排序）
function quick_sort($array)
{
    if (count($array) <= 1) return $array;
    $key = $array [0];
    $left_arr = array();
    $right_arr = array();
    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] <= $key)
            $left_arr [] = $array[$i];
        else
            $right_arr[] = $array[$i];
    }
    $left_arr = quick_sort($left_arr);
    $right_arr = quick_sort($right_arr);
    return array_merge($left_arr, array($key), $right_arr);
}

//------------------------
// PHP内置字符串函数实现
//------------------------
//字符串长度
function strlen($str)
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
function substr($str, $start, $length = NULL)
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
function strrev($str)
{
    $rev_str = '';
    if ($str == '') return 0;
    for ($i = (strlen($str) - 1); $i >= 0; $i--) {
        $rev_str .= $str[$i];
    }
    return $rev_str;
}

//字符串比较
function strcmp($s1, $s2)
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
function strstr($str, $substr)
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

//--------------------
// 自实现字符串处理函数
//--------------------
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

/*学用php算法*/
/*1、冒泡法
    *思路分析：在要排序的一组数中，对当前还未排好的序列，
    *从前往后对相邻的两个数依次进行比较和调整，让较大的数往下沉，较小的往上冒。
    *即，每当两相邻的数比较后发现它们的排序与排序要求相反时，就将它们互换。
    *比如：
    *第一次循环:第一步(1:43)第二步(43:54)第三步(54:62)第四步(62:21)这时则死换变成了(21:62)........(76:39)
    *第二次循环:第一步(1:43)第二步(43:54)第三步(54:62)第四步(62:21)这时则死换变成了(21:62)........(36:76)

*/

$arr = array(1, 43, 54, 62, 21, 66, 32, 78, 36, 76, 39);
function bubbleSort($arr)
{
    $len = count($arr);
    //该层循环控制 需要冒泡的轮数
    for ($i = 1; $i < $len; $i++) { //该层循环用来控制每轮 冒出一个数 需要比较的次数
        for ($k = 0; $k < $len - $i; $k++) {
            if ($arr[$k] > $arr[$k + 1]) {
                $tmp = $arr[$k + 1];
                $arr[$k + 1] = $arr[$k];
                $arr[$k] = $tmp;
            }
        }
    }
    return $arr;
}


/*2.选择排序
    *思路分析：在要排序的一组数中，选出最小的一个数与第一个位置的数交换。
    *然后在剩下的数当中再找最小的与第二个位置的数交换，如此循环到倒数第二个数和最后一个数比较为止。
*/
function selectSort($arr)
{
    //双重循环完成，外层控制轮数，内层控制比较次数(7.5.2.9.3)
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        //先假设最小的值的位置
        $p = $i;

        for ($j = $i + 1; $j < $len; $j++) {
            //$arr[$p] 是当前已知的最小值
            if ($arr[$p] > $arr[$j]) {
                //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                $p = $j;
            }
        }
        //已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
        if ($p != $i) {
            $tmp = $arr[$p];
            $arr[$p] = $arr[$i];
            $arr[$i] = $tmp;
        }
    }
    //返回最终结果
    return $arr;
}


