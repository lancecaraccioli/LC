<?php
namespace LC\Debug;

interface EmailTransport
{
    public function setBodyText();

    public function setBodyHtml();

    public function setSubject();

    public function setRecipient();

    public function send();
}