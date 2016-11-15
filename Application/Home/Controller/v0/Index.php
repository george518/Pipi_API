<?php
/************************************************************
** @Description: 测试
** @Author: haodaquan
** @Date:   2016-11-07
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-07
*************************************************************/

namespace Application\Home\Controller\v0;
use \Pipi\Library\Controller;
use Application\Home\Model\UserModel as User;

class Index extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// dump($this->get);
		// dump($this->keyId);
		// dump($this->mothod);
		// dump($this->post);
		// dump($this->header);
		// dump(C('ROUTE_DATA'));
		// dump($_GET);
		// dump(C());

		// dump(app_fun());

		$user = new User();
		// dump($user);
		// echo $user->getList();

		// $user->insert_data(['']);
		//$res = $user->test();
		//$res = $user->getList();
		$res = $user->updateData();
		dump($res);
	}
} 