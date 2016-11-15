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
			default:
				$this->normalUrl();
				break;
		}
		
	}

	/**
	 * [normalUrl 接口-正常url模式]
	 * @return [type] [description]
	 */
	protected function normalUrl()
	{
		#http://localhost/module/v0/controller/action/{id}?param1=param1&param2=param2
		#路由检测		
		$this->route = url_handle();
	}



}