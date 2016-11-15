<?php
namespace Application\Home\Model;
use Pipi\Library\Model as Model;

class UserModel extends Model
{
	protected $m;

	public function __construct()
	{
		$this->m = M('user');
	}

	public function add()
	{
		$data  = ['name'=>'daquan','age'=>12];
		return $this->m->data($data)->add();
	}


	public function getList($limit=3,$where='age=12')
	{
		return  $this->m->where($where)->limit($limit)->select();
	}

	public function updateData()
	{
		$data = ['name'=>'daqqq'];
		return $this->m->data($data)->where(' age=12 ')->save();
	}

	public function insert_data($data)
	{
		
	}


}