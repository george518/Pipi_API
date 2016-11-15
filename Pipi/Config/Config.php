<?php
/************************************************************
** @Description: 全局配置加载项
** @Author: haodaquan
** @Date:   2015-11-06
** @Last Modified by:   hadoaquan
** @Last Modified time: 2015-11-06
*************************************************************/

return [
	'MODULE'         => 'Home',     #默认模块
	'CONTROLLER'     => 'Index',    #默认控制器
	'ACTION'         => 'Index',


	'APP_TYPE'       => 1, #1-接口
	'URL_MODULE'     => 1, #普通接口模式 #http://localhost/module/v0/controller/action/{id}?param1=param1&param2=param2

	'URI_VERSION'    => 'v0',
	'APP_NAME'       => 'Application',

	#传输
	'HTTP_HEAD_PREFIX' => 'PIPI'

	
];