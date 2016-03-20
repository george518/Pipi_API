<?php 
namespace Common;
use Common\View as View;

class Controller
{
	public $viewHandle;
	public function __construct(){
		$this->viewHandle = new View();
	}
	public function __call($method,$args) {
        echo  $method.' is not exist!';
        // var_dump($args);
    }
}