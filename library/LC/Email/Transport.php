<?php
namespace LC\Email;

interface Transport
{
    public function setBodyText($bodyText);

    public function setBodyHtml($bodyHtml);

    public function setSubject($subject);

    public function setSender($sender);

    public function setRecipient($recipient);

    public function send();
}