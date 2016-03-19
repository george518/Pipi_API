<?php
namespace Application\Home\Controller;
use Common\Controller as Controller;

class IndexController extends Controller
{
	public function index()
	{
		$ss = M('user');
		pdump($ss);
		$db  = M('user')
					->fields('id,name')
					->where('id<100')
					->order(' id DESC ')
					->select();	
		$data = array(
				'name'=>'haopipi3',
				'age' =>5
			);
		//$res = M('user')->data($data)->add();

		//dump($res);
	}

	public function memcached()
	{
		echo "detail!";
	}
}