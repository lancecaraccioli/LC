<?php
namespace LC\Debug;
use LC\Debug;
use LC\Debug\Writer;
use LC\Debug\Writer\Html;
use LC\Debug\Writer\Chrome;
use LC\Debug\Writer\CommandLine;
use LC\Debug\Writer\Email;
use LC\Email\Transport;
use \ReflectionClass;


class Factory
{
    const html = 'html';
    const commandLine = 'commandLine';
    const chrome = 'chrome';
    const email = 'email';

    public static function makeIntelligently()
    {
        if (php_sapi_name() == 'cli') {
            $type = self::commandLine;
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
            $type = self::chrome;
        } else {
            $type = self::html;
        }
        return self::make($type);
    }

    public static function make($type)
    {
        $factory = new self();
        return $factory->build($type);
    }

    public function build($type)
    {
        $myReflection = new ReflectionClass($this);
        $myArguments = func_get_args();
        array_shift($myArguments); //remove "type" from argument list
        $methodName = 'buildDebuggerWith' . ucfirst($type) . 'Writer';
        $myReflectionMethod = $myReflection->getMethod($methodName);
        if ($myReflectionMethod->isPublic()) {
            return $myReflectionMethod->invokeArgs($this, $myArguments);
        }
    }

    public function buildDebuggerWithHtmlWriter()
    {
        $writer = new Html();
        $debugger = new Debug();
        $debugger->setWriter($writer);
        return $debugger;
    }

    public function buildDebuggerWithCommandLineWriter()
    {
        $writer = new CommandLine();
        $debugger = new Debug();
        $debugger->setWriter($writer);
        return $debugger;
    }

    public function buildDebuggerWithChromeWriter()
    {
        $writer = new Chrome();
        $debugger = new Debug();
        $debugger->setWriter($writer);
        return $debugger;
    }

    public function buildDebuggerWithEmailWriter(Transport $transport)
    {
        $writer = new Email();
        $writer->setEmailTransport($transport);
        $debugger = new Debug();
        $debugger->setWriter($writer);
        return $debugger;
    }

}