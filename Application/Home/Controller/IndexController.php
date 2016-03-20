<?php
namespace Application\Home\Controller;
use Common\Controller as Controller;
use Application\Home\Model\UserModel as User;

class IndexController extends Controller
{
	public function index()
	{

		$user = new User();
		dump($user);
		echo $user->getList();
	}

	public function memcached()
	{
		echo "detail!";
	}
}