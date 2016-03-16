<?php 
namespace Common;

class Controller
{
	public function __call($method,$args) {
        echo  $method.' is not exist!';
        // var_dump($args);
    }
}