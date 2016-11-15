<?php
/************************************************************
** @Description: 基础控制器
** @Author: haodaquan
** @Date:   2016-11-09
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-09
*************************************************************/

namespace Pipi\Library;

class Controller 
{
	public $get;
	public $post;
	public $header;
	public $mothod;
	public $keyId;
	public $db;

	public function __construct()
	{
		$this->mothod 	= isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
		$this->get 		= $_GET;
		$this->post   	= $_POST;
		$this->header 	= get_header_info(C('HTTP_HEAD_PREFIX'));
		$this->keyId    = C('ROUTE_DATA.keyId');
		$this->db       = false;

		#加载配置
		Controller::appAutoload();

	}

	/**
	 * [appAutoload 加载自动加载文件]
	 * @return [type] [description]
	 */
	static public function appAutoload()
	{
		$appAutoloadFile = APP_PATH.'Common/Autoload.php';
		if (!is_file($appAutoloadFile)) return false;
		C(require($appAutoloadFile));

		#加载项目配置
		if(C('APP_AUTOLOAD_CONFIG')!='')
		{
			foreach (C('APP_AUTOLOAD_CONFIG') as $config) {
				$configFile = APP_PATH.'Common/Config/'.$config.'.php';
				if (!is_file($configFile)) continue;
				C(require($configFile));
			}
		}

		#加载项目函数库
		if(C('APP_AUTOLOAD_FUNCTION')!='')
		{
			foreach (C('APP_AUTOLOAD_FUNCTION') as $function) {
				$functionFile = APP_PATH.'Common/Function/'.$function.'.php';
				if (!is_file($functionFile)) continue;
				require($functionFile);
			}
		}
	}
}