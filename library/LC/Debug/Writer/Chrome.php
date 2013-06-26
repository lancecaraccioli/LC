<?php
namespace LC\Debug\Writer;
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
