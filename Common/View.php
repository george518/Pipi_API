<?php 
namespace Common;

class View{

	public $viewData = array();
	public $templatePath = '';
	public $templateName = '';

	public function __construct()
	{

	}

	public function display($templatePath='',$templateName='')
	{
		echo "This is Template";
	}

}