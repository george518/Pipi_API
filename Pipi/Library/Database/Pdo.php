<?php
/************************************************************
** @Description: 数据库连接PDO
** @Author: haodaquan
** @Date:   2016-11-14
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-14
*************************************************************/

namespace Pipi\Library\Database;

class Pdo
{
	static public $connect;

	/**
	 * [__construct 不允许直接实例化]
	 */
	private function __construct()
	{
		echo "created not allowd";
	}

	/**
	 * [getInstance 单利模式实例数据库]
	 * @param  string $dbConfig [数据库配置数组]
	 * @return [type]           [description]
	 */
	static public function getInstance($dbConfig='')
	{
		if($dbConfig=='') return false;

		if(!self::$connect) 
		{
			$dsn = 'mysql:dbname='.$dbConfig['DB_NAME'].';host='.$dbConfig['DB_HOST'].':'.$dbConfig['DB_PORT'];
			self::$connect = new \PDO($dsn, $dbConfig['DB_USER'], $dbConfig['DB_PWD']);
		}
		return self::$connect;
	}

	/**
	 * [getError 获取错误]
	 * @return [type] [description]
	 */
	static public function getError()
	{
		return self::$connect->errorInfo();
	}
}