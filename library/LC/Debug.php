<?php
namespace LC;
use LC\Debug\AbstractWriter;

class Debug
{

    /**
     * @var LC\Debug\Writer the backend of the debugger
     */
    protected $_writer;

    public function setWriter(AbstractWriter $writer)
    {
        $this->_writer = $writer;
    }

    public function getWriter()
    {
        if (!$this->_writer) {
            throw new Exception('Must set debug writer (use factory which does this for you)');
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

    /**
     * PHP magic
     * usage example:
     *   $debug = new Debug(...);
     *   $debug([$data[,$moreData[,...]]]);
     *
     * 1. An arbitrary number of parameters may be passed into the method and each will be included in the debugging out put
     * 2. If no data is provided then the variables defined in the local scope get_defined_vars will be dumped
     */
    public function __invoke()
    {
        $data = func_get_args();
        if (empty($data)) {
            $data = get_defined_vars();
        }
        return $this->dump($data);
    }
}
