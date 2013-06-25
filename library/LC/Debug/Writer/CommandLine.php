<?php
namespace LC\Debug\Writer;
use LC\Debug\AbstractWriter;

require_once('LC/Debug/AbstractWriter.php');

/**
 * This class is intended to dump data into the command line console
 *
 */
class CommandLine extends AbstractWriter
{
    public function dump($data)
    {
        var_dump($data);
    }
}
