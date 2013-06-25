<?php
namespace LC\Debug\Writer;
use LC\Debug\Writer;

require_once('LC/Debug/Writer.php');

//I know... this is ugly...
require_once(__DIR__ . '/../../ThirdParty/ChromePhp.php');
/**
 * This class is intended to dump data into the chrome debug console
 *
 */
class Chrome extends Writer
{
    public function dump($data)
    {
        ChromePhp::log($data);
    }
}
