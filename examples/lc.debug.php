<?php
ini_set('include_path', implode(PATH_SEPARATOR, array(
    get_include_path(),
    realpath(__DIR__ . '/../library/'),
)));
require_once('LC/Debug/Factory.php');
use LC\Debug\Factory as DebuggerFactory;

/**
 * Because debugging is a development time type of functionality that is typically not very coupled to anything, set up a convient
 * global functions named "dump" and "kill" to wrap the debugger... base the adapter on a configuration option...
 * in an ideal world a dependecy injection container would be setup to handle the wiring.
 */
$debuggerFactory = new DebuggerFactory();

/**
 * demo data
 */
$data = array(
    'foo' => 'foo value',
    'bar' => 'bar value',
    'baz' => 'baz value'
);

//chrome
$debugger = $debuggerFactory->buildDebuggerWithChromeWriter();
$debugger->dump($data); //dump chrome dev tools console format

//html
$debugger = $debuggerFactory->buildDebuggerWithHtmlWriter();
$debugger->dump($data); //dump html output format

//command line
$debugger = $debuggerFactory->buildDebuggerWithCommandLineWriter();
$debugger->dump($data);//dump command line output format


/**
 * @todo implement basic email transport for proof of concept perhaps using as default transport (was using Zend_Mail, but wanted to decouple)
 *
 * $transport = new <class implementation of EmailTransport>
 * $debugger = $debuggerFactory->buildDebuggerWithCommandLineWriter();
 * $debugger->dump($data);//send email
 */




