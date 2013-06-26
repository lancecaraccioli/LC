<?php
//setup include path
$libraryPath = realpath(__DIR__ . '/../library');
set_include_path(get_include_path() . PATH_SEPARATOR . $libraryPath);

//setup namespace auto loader
spl_autoload_register(function ($class) {
    $fileName = str_replace('\\', '/', $class) . '.php';
    require_once($fileName);
});

use LC\Debug\Factory as DebuggerFactory;
use LC\Email\Transport\PhpMail;

try {
    /**
     * Because debugging is typically Development Time functionality that should be decoupled, set up should be convenient
     * in an ideal world a dependency injection container would be setup to handle the wiring.  If that's not available
     * the provided factory works fine enough.
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
    /**
     * Because each of the Debug Writers implement a common interface, changing the type of debug output can
     * easily be based on a configuration option (see LC\Debug\Factory::build() and constants)
     * The factory also has convenience methods for specific types of debuggers (used below)
     */


    //chrome
    //alternative generic method: LC\Debug\Factory::build(LC\Debug\Factory::chrome)
    $debugger = $debuggerFactory->buildDebuggerWithChromeWriter();
    $debugger->dump($data); //dump chrome dev tools console format

    //html
    //alternative generic method: LC\Debug\Factory::build(LC\Debug\Factory::html)
    $debugger = $debuggerFactory->buildDebuggerWithHtmlWriter();
    $debugger->dump($data); //dump html output format

    //command line
    //alternative generic method: LC\Debug\Factory::build(LC\Debug\Factory::commandLine)
    $debugger = $debuggerFactory->buildDebuggerWithCommandLineWriter();
    $debugger->dump($data); //dump command line output format

    /**
     * email (minor configuration required...)
     * 1.  a more specialized factory/DIC can setup a default transport for admin's etc in consuming applications
     * 2.  OR a consuming application can create a specialized transport
     * 3.  OR etc... lots of options for consumers.
     */
    $mailTransport = new PhpMail();
    $mailTransport->setRecipient('lance.caraccioli@gmail.com');
    $mailTransport->setSender('lcaraccioli@elance.com');
    //alternative generic method: LC\Debug\Factory::build(LC\Debug\Factory::email, $mailTransport)
    $debugger = $debuggerFactory->buildDebuggerWithEmailWriter($mailTransport);
    $debugger->dump($data); //sends an email

} catch (Exception $e) {
    echo get_include_path();
    echo "\n";
    die($e->getMessage());
}



