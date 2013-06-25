<?php
namespace LC\Debug\Writer;
use LC\Debug\Writer;

require_once('LC/Debug/Writer.php');

/**
 * This class is intended to dump data into the command line console
 *
 */
class CommandLine extends Writer
{
    public function dump($data)
    {
        var_dump($data);
    }
}
