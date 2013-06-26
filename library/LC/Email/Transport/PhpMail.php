<?php
namespace LC\Email\Transport;
use LC\Email\Transport;
use \Exception;

class PhpMail implements Transport
{
    protected $_bodyText;
    protected $_bodyHtml;
    protected $_subject;
    protected $_sender;
    protected $_recipient;

    /**
     * @param mixed $bodyHtml
     */
    public function setBodyHtml($bodyHtml)
    {
        $this->_bodyHtml = $bodyHtml;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyHtml()
    {
        throw new Exception("Html not supported by this transport.  Use [set/get]BodyText instead.");
    }

    /**
     * @param mixed $bodyText
     */
    public function setBodyText($bodyText)
    {
        $this->_bodyText = $bodyText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyText()
    {
        return $this->_bodyText;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient)
    {
        $this->_recipient = $recipient;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->_recipient;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->_sender = $sender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_sender;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    public function send()
    {
        $headers = 'From: ' . $this->getSender() . "\r\n";
        mail($this->getRecipient(), $this->getSubject(), $this->getBodyText(), $headers);
    }
}