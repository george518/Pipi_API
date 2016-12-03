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
	public $method;
	public $keyId;
	public $db;

	public function __construct()
	{
		$this->method 	= isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
		$this->get 		= $_GET;
		$this->post   	= $_POST;
		$this->header 	= get_header_info(C('HTTP_HEAD_PREFIX'));
		$this->keyId    = C('ROUTE_DATA.keyId');
		$this->db       = false;
		#加载配置
		Controller::appAutoload();
		#接口权限验证
		$this->authCheck();

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


	/**
	 * [authCheck 检查接口调用者合法性]
	 * @return [type] [description]
	 */
	protected function authCheck()
	{
		if( !isset($this->get['ts']) || 
			!isset($this->get['app_key']) || 
			!isset($this->get['method']) || 
			!isset($this->get['sign'])){
			$this->ajaxReturn([],300,'签名错误');
		}
        
		$app_sign = C('APP_SIGN');
        $check =[
            'app_key=' . $this->get['app_key'],
            'app_secret='. $app_sign[$this->get['app_key']],
            'method=' . $this->get['method'],
            'ts=' . $this->get['ts']];

            //dump($check);
        sort($check);
        if(md5(sha1(join("&", $check)))!==$this->get['sign'])
        {
        	$this->ajaxReturn([],300,'签名验证错误');
        }
        return true;
	}

	/**
	* [ajaxReturn 返回ajax数据]
	* @Date   2016-06-06
	* @param  array      $data     [返回数据]
	* @param  integer    $status   [状态码]
	* @param  string     $messages [提示信息]
	* @return [type]               [description]
	*/
	public function ajaxReturn($data=[],$status=200,$messages="操作成功")
	{
		echo  json_encode(
			['status'=>$status,'message'=>$messages,'data'=>$data]
		);
		exit();
	}
}