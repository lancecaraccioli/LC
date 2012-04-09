<?php
ini_set('include_path', implode(PATH_SEPARATOR, array(
	get_include_path(),
	realpath(__DIR__.'/../library/'),
)));
require_once('LC/Debug.php');
require_once('LC/Debug/Inspector/Html.php');
require_once('LC/Debug/Inspector/CommandLine.php');
require_once('LC/Debug/Inspector/Email.php');
require_once('LC/Debug/Inspector/Chrome.php');
require_once('Zend/Mail.php');
require_once('Zend/Mail/Transport/Smtp.php');

/**
 * Because debugging is a development time type of functionality that is typically not very coupled to anything, set up a convient
 * global functions named "dump" and "kill" to wrap the debugger... base the adapter on a configuration option... 
 * in an ideal world a dependecy injection container would be setup to handle the wiring. 
 */

$debugger = new LC_Debug();
$data = array(
	'foo'=>'bar',
	'zoo'=>'jar',
	'etc'=>'ect'
);

//chrome
$adapter = new LC_Debug_Inspector_Chrome();
$debugger->setInspector($adapter);
$debugger->dump($data);

//html
$adapter = new LC_Debug_Inspector_Html();
$debugger->setInspector($adapter);
$debugger->dump($data);

//command line
$adapter = new LC_Debug_Inspector_CommandLine();
$debugger->setInspector($adapter);
$debugger->dump($data);

//email
$adapter = new LC_Debug_Inspector_Email();
//why not have a setTransport on Zend_Mail ideally one would extend Zend_Mail to add this, or submit an upgrade to zend developer network?
$smtpHost = '';
$emailTo = '';
$emailFrom = '';
//ugg
Zend_Mail::setDefaultTransport(new Zend_Mail_Transport_Smtp($smtpHost));
$mailer = new Zend_Mail();
$mailer->addTo($emailTo, 'Receiver Name');
$mailer->setFrom($emailFrom, 'Sender Name');
$adapter->setMailer($mailer);
$debugger->setInspector($adapter);
$debugger->dump($data);


