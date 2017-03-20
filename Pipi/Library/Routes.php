<?php
/************************************************************
** @Description: 路由类
** @Author: haodaquan
** @Date:   2016-11-6
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-6
*************************************************************/

namespace Pipi\Library;

class Routes
{
	public $route; #路由参数
	/**
	 * [__construct 初始化方法，划分]
	 */
	public function __construct()
	{
		#后期实现支持多种模式
		switch (C('URL_MODULE')) {
			case 1:
				$this->normalUrl();
				break;
			case 2:
				$this->mapUrl();
				break;
			default:
				$this->normalUrl();
				break;
		}
		
	}

	/**
	 * [normalUrl 接口-正常url模式 按照module/v0/controller/action/{id}]
	 * @return [type] [description]
	 */
	protected function normalUrl()
	{
		#http://localhost/module/v0/controller/action/{id}?param1=param1&param2=param2
		$uri    = trim($_SERVER['REQUEST_URI'],' ');
	    $urlArr = explode('?',$uri);
	    $mca    = explode('/', (trim($urlArr[0],'/')));
	    
	    $route  = []; 
	    $route['module']     = isset($mca[0]) ? $mca[0] : C('MODULE');
	    $route['version']    = isset($mca[1]) ? $mca[1] : C('URI_VERSION');
	    $route['controller'] = isset($mca[2]) ? $mca[2] : C('CONTROLLER');
	    $route['action']     = isset($mca[3]) ? $mca[3] : C('ACTION');
	    $route['keyId']      = isset($mca[4]) ? (int)$mca[4] : '';
	    #设置URL
	    C('ROUTE_DATA',$route);
	
		$this->route = $route;
	}

	/**
	 * [mapUrl 映射方式 根据config->routes中的地址映射]
	 * @return [type] [description]
	 */
	protected function mapUrl()
	{
		#http://localhost/module/controller/action/{id}?param1=param1&param2=param2
		require APP_PATH.'Common/Config/Routes.php';
		$urlMap = $routesMap;
		$uri    = trim($_SERVER['REQUEST_URI'],' ');
		$urlArr = explode('?',$uri);
		$mca    = explode('/', (trim($urlArr[0],'/')));

		$route  = [];

		$keyId  = end($mca);
		$mapKey = $urlArr[0];
		if (is_numeric($keyId)) {
			$route['keyId']      = $keyId;
			$mapKey = rtrim($mapKey,'/'.$keyId).'/:id';
		}else
		{
			$route['keyId']      = 0 ;
		}

		$route['module']     = C('MODULE');
	    $route['version']    = C('URI_VERSION');
	    $route['controller'] = C('CONTROLLER');
	    $route['action']     = C('ACTION');

	    #不区分大小写 TODO
		if(isset($urlMap[$mapKey]))
		{
			$mapValue = explode('/', (trim($urlMap[$mapKey],'/')));
		    $route['module']     = isset($mapValue[0]) ? $mapValue[0] : C('MODULE');
		    $route['version']    = isset($mapValue[1]) ? $mapValue[1] : C('URI_VERSION');
		    $route['controller'] = isset($mapValue[2]) ? $mapValue[2] : C('CONTROLLER');
		    $route['action']     = isset($mapValue[3]) ? $mapValue[3] : C('ACTION');
		}
		C('ROUTE_DATA',$route);
		$this->route = $route;
	}

}