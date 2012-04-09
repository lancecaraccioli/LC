<?php
require_once('LC/Debug/Inspector.php');
require_once('Zend/Mail.php');
/**
 * This class is intended to dump data into the command line console
 * 
 */
class LC_Debug_Inspector_Email extends LC_Debug_Inspector{
	protected $_mailer;
	
	public function dump($data){
		$serializedData = print_r($data,true);
		$this->getMailer()
			->setBodyText($serializedData)
			->setBodyHtml('<pre>'.$serializedData.'</pre>')
			->setSubject("Debugging Output sent from ".$_SERVER['SERVER_ADDR']." at ".date('Y-m-d H:i:s'))
			->send();
	}
	
	public function getMailer(){
		if (!$this->_mailer){
			throw new Exception("You must first specify a Zend_Mail object to handle sending the email.");
		}
		return $this->_mailer;
	}
	
	public function setMailer(Zend_Mail $mailer){
		$this->_mailer = $mailer;
	}
}
