<?php
namespace Common;
/**
 * 核心文件
 */
class Cores
{
	static public function run()
	{
		if(Cores::loadFunctions())
		{
			C(Cores::loadConfigs());
		}
		//路由
		require COM_PATH.'Routes.php';
		Routes::route();
	}

	static public function loadConfigs()
	{
		return require COM_PATH.'Configs.php';
	}

	static public function loadFunctions()
	{
		return require COM_PATH.'Functions.php';
	}
	
}