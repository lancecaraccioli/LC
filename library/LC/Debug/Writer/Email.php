<?php
namespace LC\Debug\Writer;
use LC\Debug\AbstractWriter;
use LC\Email\Transport;


/**
 * This class is intended to dump data into the command line console
 *
 */
class Email extends AbstractWriter
{
    protected $_emailTransport;

    public function dump($data)
    {
        $serializedData = print_r($data, true);
        $serverInfo = ($_SERVER['SERVER_NAME'] ? : $_SERVER['HOSTNAME']) . '[' . $_SERVER['SERVER_ADDR'] . ']';
        $this->getEmailTransport()
            ->setBodyText($serializedData)
            ->setBodyHtml('<pre>' . $serializedData . '</pre>')
            ->setSubject('Debugging Output sent from ' . $serverInfo . ' at ' . date('Y-m-d H:i:s'))
            ->send();
    }

    /**
     * @return Transport
     * @throws Exception
     */
    public function getEmailTransport()
    {
        if (!$this->_emailTransport) {
            throw new Exception("You must first specify an LC\\Email\\Transport object to handle sending the email.");
        }
        return $this->_emailTransport;
    }

    public function setEmailTransport(Transport $emailTransport)
    {
        $this->_emailTransport = $emailTransport;
    }
}
