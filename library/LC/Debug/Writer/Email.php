<?php
namespace LC\Debug\Writer;
require_once('LC/Debug/AbstractWriter.php');
require_once('LC/Debug/EmailTransport.php');
use LC\Debug\AbstractWriter;
use LC\Debug\EmailTransport;


/**
 * This class is intended to dump data into the command line console
 *
 */
class Email extends AbstractWriter
{
    protected $_mailer;

    public function dump($data)
    {
        $serializedData = print_r($data, true);
        $this->getMailer()
            ->setBodyText($serializedData)
            ->setBodyHtml('<pre>' . $serializedData . '</pre>')
            ->setSubject("Debugging Output sent from " . $_SERVER['SERVER_ADDR'] . " at " . date('Y-m-d H:i:s'))
            ->send();
    }

    public function getMailer()
    {
        if (!$this->_mailer) {
            throw new Exception("You must first specify an EmailTransport object to handle sending the email.");
        }
        return $this->_mailer;
    }

    public function setMailer(EmailTransport $mailer)
    {
        $this->_mailer = $mailer;
    }
}
