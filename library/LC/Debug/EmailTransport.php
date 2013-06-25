<?
namespace LC\Debug;

abstract class EmailTransport
{

    public abstract function setBodyText();

    public abstract function setBodyHtml();

    public abstract function setSubject();

    public abstract function setRecipient();

    public abstract function send();

}