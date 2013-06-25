<?
namespace LC\Debug;
use LC\Debug;
use LC\Debug\Writer;
use LC\Debug\EmailTransport;
use LC\Debug\Writer\Html;
use LC\Debug\Writer\Chrome;
use LC\Debug\Writer\CommandLine;
use LC\Debug\Writer\Email;
use \ReflectionClass;

require_once('LC/Debug.php');
require_once('LC/Debug/AbstractWriter.php');
require_once('LC/Debug/AbstractWriter/Chrome.php');
require_once('LC/Debug/AbstractWriter/Html.php');
require_once('LC/Debug/AbstractWriter/CommandLine.php');
require_once('LC/Debug/AbstractWriter/Email.php');
require_once('LC/Debug/EmailTransport.php');

class Factory
{
    const html = 'html';
    const commandLine = 'commandLine';
    const chrome = 'chrome';
    const email = 'email';

    public function build($type)
    {
        $myReflection = new ReflectionClass($this);
        $myArguments = func_get_args();
        array_shift($myArguments); //remove "type" from argument list
        $methodName = 'buildDebuggerWith' . ucfirst($type) . 'AbstractWriter';
        $myReflectionMethod = $myReflection->getMethod($methodName);
        if ($myReflectionMethod->isPublic()) {
            $myReflectionMethod->invokeArgs($this, $myArguments);
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

    public function buildDebuggerWithEmailWriter(EmailTransport $transport)
    {
        $writer = new Email();
        $writer->setMailer($transport);
        $debugger = new Debug();
        $debugger->setWriter($writer);
        return $debugger;
    }

}