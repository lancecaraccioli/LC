<?php
require_once('LC/Debug/Inspector.php');
/**
 * This class is intended to dump data into html being returned to the browser
 * 
 */
class LC_Debug_Inspector_Html extends LC_Debug_Inspector{
	public function dump($data){
		echo("<pre>");
		var_dump($data);
		echo("</pre>");
	}
	
	public function kill($data){
		$this->dump($data);
		die();
	}
}
