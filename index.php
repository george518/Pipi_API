<?php
/************************************************************
** @Description: 框架入口
** @Author: haodaquan
** @Date:   2016-11-05 09:04:07
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-05 13:28:04
*************************************************************/

#判断PHP版本必须在5.3以上
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

#定义常量
define('ROOT_PATH',realpath('./'));
define('CORE_PATH',ROOT_PATH.'/Pipi/');
define('APP_PATH', ROOT_PATH.'/Application/');
#环境  * development=1 * production=2
define('ENVIRONMENT',1);
#启动框架
require(CORE_PATH.'Cores.php');
Pipi\Cores::run();
