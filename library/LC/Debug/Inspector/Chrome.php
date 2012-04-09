<?php
require_once('LC/Debug/Inspector.php');
//I know... this is ugly...
require_once(__DIR__.'/../../ThirdParty/ChromePhp.php');
/**
 * This class is intended to dump data into the chrome debug console
 * 
 */
class LC_Debug_Inspector_Chrome extends LC_Debug_Inspector{
	public function dump($data){
		ChromePhp::log($data);
	}
	
	public function kill($data){
		$this->dump($data);
		die();
	}
}
