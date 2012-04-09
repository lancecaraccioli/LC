<?php
require_once('LC/Debug/Inspector.php');
/**
 * This class is intended to dump data into the command line console
 * 
 */
class LC_Debug_Inspector_CommandLine extends LC_Debug_Inspector{
	public function dump($data){
		var_dump($data);
	}
	
	public function kill($data){
		$this->dump($data);
		die();
	}
}
