<?php
    //入口文件	
	define('ROOT_PATH',dirname(__FILE__));
	define('APP_PATH','/Application/');
	define('COM_PATH',ROOT_PATH.'/Common/');
	
	require ROOT_PATH.'/Common/Cores.php';
	Common\Cores::run();

