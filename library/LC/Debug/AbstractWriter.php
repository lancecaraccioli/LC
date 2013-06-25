<?php
namespace LC\Debug;

require_once('LC/Debug/Writer.php');
use LC\Debug\Writer;

abstract class AbstractWriter implements Writer
{
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

}