<?php
namespace Common\Db;

class Pdo
{
	static public $connect;

	private function __construct()
	{
		echo "created not allowd";
	}

	static public function getInstance()
	{
		$dbConfig = C('DB_DEFAULT');
		if(!self::$connect) 
		{
			$dsn = 'mysql:dbname='.$dbConfig['DB_NAME'].';host='.$dbConfig['DB_HOST'].':'.$dbConfig['DB_PORT'];
			self::$connect = new \PDO($dsn, $dbConfig['DB_USER'], $dbConfig['DB_PWD']);
		}
		return self::$connect;
	}

	

}