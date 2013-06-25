<?php
namespace LC\Debug\Writer;
use LC\Debug\Writer;

require_once('LC/Debug/Writer.php');
/**
 * This class is intended to dump data into html being returned to the browser
 *
 */
class Html extends Writer
{
    public function dump($data)
    {
        echo("<pre>");
        var_dump($data);
        echo("</pre>");
    }

    public function kill($data)
    {
        $this->dump($data);
        die();
    }
}
