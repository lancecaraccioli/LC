<?php
namespace LC\Debug\Writer;
use LC\Debug\AbstractWriter;

require_once('LC/Debug/AbstractWriter.php');

//I know... this is ugly...
require_once(__DIR__ . '/../../ThirdParty/ChromePhp.php');
/**
 * This class is intended to dump data into the chrome debug console
 *
 */
class Chrome extends AbstractWriter
{
    public function dump($data)
    {
        ChromePhp::log($data);
    }
}
