<?php 
namespace Common;

class Routes
{
	static public function route()
	{
		$requestUri    = $_SERVER['REQUEST_URI'];
		$requestUriArr = explode('/', (trim($_SERVER['REQUEST_URI'],'/')));
		$paramNum = count($requestUriArr);
		$module        = $paramNum >=3 ? $requestUriArr[0] : 'Home';
		$controller    = $paramNum >=3 ? $requestUriArr[1] : 'Index';
		$action        = $paramNum >=3 ? $requestUriArr[2] : 'Index';
		
		spl_autoload_register('Common\Routes::autoload');

		//传参数未解决＊＊＊＊＊＊＊＊＊

		$classPath = str_replace('/','\\',APP_PATH).$module.'\Controller\\'.$controller.'Controller';
		$class = new $classPath();
		return $class->$action();
	}

	//自动加载类
	static public function autoload($class)
	{
		$path = str_replace('\\', '/', $class).'.php';
		if(is_file($path))
		{
			require str_replace('\\', '/', $class).'.php';
		}
	}
}



