<?php
namespace Application\Home\Model;
use Common\Model as Model;

class UserModel extends Model
{
	public function getList($limit=3,$where='')
	{
		$res = M('user')->where($where)->limit($limit)->select();
		dump($res);
	}
}