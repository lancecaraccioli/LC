<?php
namespace LC\Debug\Writer;
use LC\Debug\AbstractWriter;

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
