<?php
/************************************************************
** @Description: 接口调用demo
** @Author: haodaquan
** @Date:   2016-12-02
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-12-04 00:39:24
*************************************************************/

define('APP_KEY', '1001');
define('APP_SECRET','ed7f8b373db9b733dc0dee62a6d184e8');
define('REQUEST_URI', 'http://pipi.com');#本地虚拟域名


$url = REQUEST_URI.'/Home/v0/Index/index';

#POST
$data = ['login_name'=>'haodaquan','password'=>'123456','name'=>'haodaquan','gender'=>1];
$result = http($url,$data,'POST',[],5,true);
echo $result;

#GET
// $data   = ['pageSize'=>10,'pageCurrent'=>1,'gender'=>1];
// $result = http($url,$data,'GET',[],5,true);
// echo $result;

#put
// $data   = ['login_name'=>'edit_name','password'=>22332233,'gender'=>2];
// $url .= '/1'; 
// $result = http($url,$data,'PUT',[],5,true);
// echo $result;


#delete
// $url .= '/2'; 
// $result = http($url,[],'DELETE',[],5,true);
// echo $result;


//$params = ['pageSize'=>10,'pageCurrent'=>1,'']





/**
 * [http 调用接口函数]
 * @Date   2016-07-11
 * @Author GeorgeHao
 * @param  string       $url     [接口地址]
 * @param  array        $params  [数组]
 * @param  string       $method  [GET\POST\DELETE\PUT]
 * @param  array        $header  [HTTP头信息]
 * @param  integer      $timeout [超时时间]
 * @param  boolean      $sign    [是否加密]
 * @return [type]                [接口返回数据]
 */
function http($url, $params, $method = 'GET', $header =[], $timeout = 5,$sign=false)
{
    $opts = array(
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );

    if($sign)
    {
        
        $ts = time();
        $check =[
            "app_key=" . APP_KEY,
            "app_secret=" . APP_SECRET,
            "method=" . $method,
            "ts=" . $ts];
        sort($check);      
        $url .= '?sign='.md5(sha1(join("&", $check))).'&ts='.$ts.'&app_key='.APP_KEY.'&method='.$method;
    }

    //var_dump($url);
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            if($params)
            {
               $opts[CURLOPT_URL] = $url . '&' . http_build_query($params); 
            }else
            {
                $opts[CURLOPT_URL] = $url;
            }
            break;
        case 'POST':
            $params = http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        case 'DELETE':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_HTTPHEADER] = array("X-HTTP-Method-Override: DELETE");
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        case 'PUT':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 0;
            $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $opts[CURLOPT_POSTFIELDS] = http_build_query($params);
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
  
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    return $data;
}