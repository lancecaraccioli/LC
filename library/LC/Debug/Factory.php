<?
namespace LC\Debug;
use \ReflectionClass;

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
        $methodName = 'buildDebuggerWith' . ucfirst($type) . 'Writer';
        $myReflectionMethod = $myReflection->getMethod($methodName);
        if ($myReflectionMethod->isPublic()) {
            $myReflectionMethod->invokeArgs($this, $myArguments);
        }
    }

    public function buildDebuggerWithHtmlWriter()
    {

    }

}