<?php
/************************************************************
** @Description: 框架核心文件
** @Author: haodaquan
** @Date:   2016-11-5
** @Last Modified by:   haodaquan
** @Last Modified time: 2015-11-5
*************************************************************/
namespace Pipi;

class Cores
{
	static public $classMap = [];
	
	/**
	 * [run 核心启动方法]
	 * @return [type] [description]
	 */
	static public function run()
	{
		spl_autoload_register('self::autoload');
		set_error_handler('self::errorHandle');
		#加载函数库
		self::loadFunctions([]);
		#加载配置项
		C(self::loadConfigs([]));
		#加载第三方插件
		require 'vendor/autoload.php';
		#加载调试类
		self::debug();
		#加载路由
		$routeObj = new Library\Routes();

		$classPath = '\\'.C('APP_NAME').'\\'
					.$routeObj->route['module'].'\Controller\\'
					.$routeObj->route['version'].'\\'
					.$routeObj->route['controller'];

		if (!class_exists($classPath)) {
			ajaxReturn([],300,"地址错误,Controller");
		}

		$class = new $classPath();
		$function = $routeObj->route['action'];

		if(!method_exists($class,$function)){
			ajaxReturn([],300,"地址错误,Function");
		}
		return $class->$function();
	}

	/**
	 * [loadConfigs 加载全局配置]
	 * @param [array] [配置文件数组]
	 * @return [type] [description]
	 */
	static public function loadConfigs($config)
	{
		return require CORE_PATH.'Config/Config.php';
	}

	/**
	 * [loadFunctions 加载函数库]
	 * @return [type] [description]
	 */
	static public function loadFunctions($functions)
	{
		return require CORE_PATH.'Function/Function.php';
	}

	/**
	 * [autoload 自动加载类]
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	static public function autoload($class)
	{
		$path = str_replace('\\', '/', $class).'.php';
		if(!is_file($path)) return false;
		if(isset(self::$classMap[$class])) return true;
		self::$classMap[$class] = $class;
		require($path);
	}

	/**
	 * [debug 加载调试工具]
	 * @return [type] [description]
	 */
	static private function debug()
	{
		if(ENVIRONMENT!=1)
		{
			error_reporting(0);
			return true;
		}
		#E_ERROR | E_WARNING | E_PARSE
		error_reporting(E_ALL);
		$whoops = new \Whoops\Run;
		$title = "哎呀，出错了";
		$option = new \Whoops\Handler\PrettyPageHandler();
		$option->setPageTitle($title);
		$whoops->pushHandler($option);
		$whoops->register();
	}

	static public function errorHandle($errno,$errstr,$errfile,$errline,$errcontext)
	{
		echo $errfile;
		echo '<br />';
		echo $errno;
		echo '<br />';
		echo $errstr;
		echo '<br />';
		echo $errline;
		echo '<br />';
		var_dump($errcontext);
		die;
	}




}