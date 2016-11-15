<?php
/************************************************************
** @Description: 基础函数库
** @Author: haodaquan
** @Date:   2015-11-06
** @Last Modified by:   hadoaquan
** @Last Modified time: 2015-11-06
*************************************************************/

/**
 * [C 加载或者设置参数]
 * @param [type] $name    [参数key]
 * @param [type] $value   [参数值]
 * @param [type] $default [默认值]
 */
function C($name=null, $value=null,$default=null) 
{
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) return $_config;

    // 优先执行设置获取或赋值
    if (is_string($name)) 
    {
        if (!strpos($name, '.')) 
        {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return null;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return null;
    }
    // 批量设置
    if (is_array($name))
    {
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return null;
    }
    return null; // 避免非法参数
}

/**
 * [M description]
 * @param [type] $table    [description]
 * @param string $database [description]
 */
function M($table,$database='DB_DEFAULT')
{
    if(!$table) return false;
    return new \Pipi\Library\Model($table,$database);
}

/**
 * [get_header_info 返回header数据]
 * @param  string $prefix [前缀标志]
 * @return [type]         [description]
 */
function get_header_info($prefix='')
{
    $header = [];
    if (!$prefix) return $_SERVER;
    $prefix = 'HTTP_'.$prefix;
    foreach ($_SERVER as $name => $value)  
    {  
        if (strpos($name,$prefix)===0){
            $header[strtolower(str_replace('HTTP_', '', $name))] = $value;
        }  
    }  
    return $header; 
}


/**
 * [deal_url description]
 * @return [type] [description]
 */
function url_handle()
{
    $uri    = trim($_SERVER['REQUEST_URI'],' ');
    $urlArr = explode('?',$uri);
    $mca    = explode('/', (trim($urlArr[0],'/')));
    
    $route  = []; 
    $route['module']     = $mca[0] ? $mca[0] : C('MODULE');
    $route['version']    = isset($mca[1]) ? $mca[1] : C('URI_VERSION');
    $route['controller'] = isset($mca[2]) ? $mca[2] : C('CONTROLLER');
    $route['action']     = isset($mca[3]) ? $mca[3] : C('ACTION');
    $route['keyId']      = isset($mca[4]) ? (int)$mca[4] : '';
    #设置URL
    C('ROUTE_DATA',$route);

    return $route;
}



// function dump($args)
// {
// 	echo "<pre>";
// 	var_dump($args);
// }