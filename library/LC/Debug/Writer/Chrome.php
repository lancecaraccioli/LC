<?php
namespace LC\Debug\Writer;

require_once('LC/Debug/AbstractWriter.php');
require_once(__DIR__ . '/../../ThirdParty/ChromePhp.php'); //this feels ugly...

use LC\Debug\AbstractWriter;
use ThirdParty\ChromePhp;

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
