<?php
namespace Application\Home\Model;
use Pipi\Library\Model as Model;

class UserModel extends Model
{
	protected $m;

	public function __construct()
	{
		$this->m = M('pp_user');
	}

	public function addData($data)
	{
		return $this->m->data($data)->add();
	}


	public function getList($limit,$where)
	{
		return  $this->m->where($where)->limit($limit)->select();
	}

	public function updateData($data,$where)
	{
		return $this->m->data($data)->where($where)->save();
	}

	public function deleteData($where)
	{
		return $this->m->where($where)->delete();
	}

	public function insert_data($data)
	{
		
	}


}