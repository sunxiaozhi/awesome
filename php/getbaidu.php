<?php
/*
 * curl多线程查询百度收录情况
 * */
error_reporting(E_ALL | E_STRICT);
echo '<pre>';

$urls = array(
    '5' => "http://hfz.zhong5.cn/sznk_wk/zc/2839.html",
    '2' => "http://www.leshan.cn/hyzx/jkxx/3986723898.html",
    '3' => "http://www.leshan.cn/hyzx/jkxx/3986724857.html",
    '1' => "http://www.zyol.gz.cn/jkzx/jkxx/4159811671.html",
    '6' => "http://www.zyol.gz.cn/jkzx/jkxx/4159815402.html ",
    '8' => "http://www.zyol.gz.cn/jkzx/jkxx/4159812671.html ",
    '9' => "http://www.lfxww.com/plus/view.php?aid=336872 ",
    '12' => "http://www.lfxww.com/plus/view.php?aid=336874 ",
    '67' => "http://www.zznews.cn/hyzx/jkxx/4160443738.html ",
    '34' => "hhttp://www.leshan.cn/hyzx/jkxx/4160562511.html ");

//百度查搜录地址
$baidu = 'http://www.baidu.com/s?wd={url}&rsv_bp=0&ch=&tn=baidu&bar=&rsv_spt=3&ie=utf-8&rsv_n=2&rsv_sug3=1&rsv_sug1=1&rsv_sug4=2822&inputT=7012';
//替换成百度查询链接
array_walk($urls, create_function('&$v,$k,$baidu', '$v = str_replace("{url}", urlencode($v), $baidu);'), $baidu);

/**
 * 下面有两种方式处理，一种是通过回调，传入$callback，在$callback中处理,可控制返回结果
 * 还有种是获取返回结果集中处理
 * 推荐第一种
 */
$result = curl_multi($urls, null, 'deal');
print_r($result);
exit();

/**
 * 返回结果，id=>收录日期,0表示未收录
 * @param array $urls
 * @param null $head_req
 * @param null $callback
 * @return array
 */
function curl_multi($urls = array(), $head_req = null, $callback = null)
{
    $response = array();
    if (empty($urls)) return $response;
    $chs = curl_multi_init();

    $options = array(
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 30,
        isset($head_req) ? CURLOPT_NOBODY : CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_HEADER => 0);
    foreach ($urls as $id => $url) {
        $ch = curl_init($url);
        curl_setopt_array($ch, $options); //php>=5.1.3
        curl_multi_add_handle($chs, $ch);
        $map[strval($ch)] = $id;
    }
    do {
        if (($status = curl_multi_exec($chs, $active)) != CURLM_CALL_MULTI_PERFORM) {
            if ($status != CURLM_OK) {
                break;
            } //如果没有准备就绪，就再次调用curl_multi_exec
            while ($done = curl_multi_info_read($chs)) {
                $info = curl_getinfo($done['handle']);
                $error = curl_error($done['handle']);
                if (!isset($head_req)) {
                    $result = curl_multi_getcontent($done['handle']);
                    $rtn = compact('info', 'error', 'result');
                } else {
                    $rtn = compact('info', 'error');
                }
                isset($callback) && $callback($rtn);
                $response[$map[strval($done['handle'])]] = $rtn;
                curl_multi_remove_handle($chs, $done['handle']);
                curl_close($done['handle']);
                //如果仍然有未处理完毕的句柄，那么就select
                if ($active > 0) {
                    curl_multi_select($chs, 0.5); //此处会导致阻塞大概0.5秒。
                }
            }
        }
    } while ($active > 0); //还有句柄处理还在进行中
    curl_multi_close($chs);
    return $response;
}

//处理函数可自己写
function deal(&$data)
{
    if (!empty($data['error']) || $data['info']['http_code'] != 200) {
        $data = 0;
        return;
    }
    unset($data['info'], $data['error']);
    $content = $data['result'];
    unset($data['result']);
    if (strpos($content, '抱歉，没有找到与')) {
        $data = 0;
        return;
    }
    preg_match('#<span class="g">.*(\d{4}-\d{1,2}-\d{1,2})#is', $content, $match);
    $data = isset($match[1]) ? $match[1] : 0;
}