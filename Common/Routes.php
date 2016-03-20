<?php 
namespace Common;

class Routes
{
	static public function route()
	{
		//$requestUri    = $_SERVER['REQUEST_URI'];
		$requestUriArr = explode('/', (trim($_SERVER['REQUEST_URI'],'/')));
		$paramNum   = count($requestUriArr);
		$module     = 'Home';
		$controller = 'Index';
		$action     = 'index';

		if(count($requestUriArr)>=3)
		{
			$module     = $requestUriArr[0];
			$controller = $requestUriArr[1];
			$action     = $requestUriArr[2];

			unset($requestUriArr[0]);
			unset($requestUriArr[1]);
			unset($requestUriArr[2]);

			$paramValues = array_values($requestUriArr);
			$getParam = array();
			foreach ($paramValues as $key => $value) {
				if($key%2==0){
					$getParam[$value] = '';
				}else{
					$getParam[$paramValues[$key-1]] = $value;
				}
			}

			$_GET = $getParam;
		}
		spl_autoload_register('Common\Routes::autoload');

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



