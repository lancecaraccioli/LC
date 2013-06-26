<?php
namespace LC\Debug\Writer;
use LC\Debug\AbstractWriter;

/**
 * This class is intended to dump data into html being returned to the browser
 *
 */
class Html extends AbstractWriter
{
    public function dump($data)
    {
        echo("<pre>");
        var_dump($data);
        echo("</pre>");
    }

}
