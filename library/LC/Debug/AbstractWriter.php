<?php
namespace LC\Debug;
use LC\Debug\Writer;

abstract class AbstractWriter implements Writer
{
    protected $_showVerbose = false;

    /**
     * must implement Writer::dump($data);
     */

    /**
     * Dump the contents of the source data into a suitable format and then kill the execution of the php script.
     *
     * @see {link dump()}
     * @param mixed $data is the source data that should be inspected by the inspector
     */
    public function kill($data)
    {
        $this->dump($data);
        die();
    }

    public function showVerbose($showVerboseOutput = null)
    {
        if (null !== $showVerboseOutput) {
            $this->_showVerbose = $showVerboseOutput ? true : false;
        }
        return $this->_showVerbose;
    }
}