<?
namespace LC;
use LC\Debug\Writer;
use LC\Debug\Writer\Html;

require_once('LC/Debug/Writer.php');
require_once('LC/Debug/Writer/Html.php');

class Debug
{

    /**
     * @var LC\Debug\Writer the backend of the debugger
     */
    protected $_writer;

    public function setWriter(Writer $inspector)
    {
        $this->_writer = $inspector;
    }

    public function getWriter()
    {
        if (!$this->_writer) {
            return new Html();
        }
        return $this->_writer;
    }

    public function dump($data)
    {
        $this->getWriter()->dump($data);
    }

    public function kill($data)
    {
        $this->getWriter()->kill($data);
    }
}
