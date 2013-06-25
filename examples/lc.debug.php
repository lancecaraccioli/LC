<?php
ini_set('include_path', implode(PATH_SEPARATOR, array(
    get_include_path(),
    realpath(__DIR__ . '/../library/'),
)));
use LC\Debug;
use LC\Debug\Writer\Html;
use LC\Debug\Writer\Chrome;
use LC\Debug\Writer\CommandLine;
use LC\Debug\Writer\Email;

require_once('LC/Debug.php');
require_once('LC/Debug/Writer/Html.php');
require_once('LC/Debug/Writer/CommandLine.php');
require_once('LC/Debug/Writer/Email.php');
require_once('LC/Debug/Writer/Chrome.php');

/**
 * Because debugging is a development time type of functionality that is typically not very coupled to anything, set up a convient
 * global functions named "dump" and "kill" to wrap the debugger... base the adapter on a configuration option...
 * in an ideal world a dependecy injection container would be setup to handle the wiring.
 */

$debugger = new Debug();
$data = array(
    'foo' => 'bar',
    'zoo' => 'jar',
    'etc' => 'ect'
);

//chrome
$writer = new Chrome();
$debugger->setWriter($writer);
$debugger->dump($data);

//html
$writer = new Html();
$debugger->setWriter($writer);
$debugger->dump($data);

//command line
$writer = new CommandLine();
$debugger->setWriter($writer);
$debugger->dump($data);


/**
 * @todo implement basic email transport for proof of concept (was using Zend_Mail, but wanted to decouple)
 *
 * $writer = new Email();
 */




