<?php
namespace LC\Rest\Client;
use LC\Rest\Client;

/**
 * Class Jira
 *
 * Proof of concept.
 * @TODO a lot.
 *
 * @package LC\Rest\Client
 */
class Jira extends Client
{
    /**
     * @param $username
     * @param $password
     *
     * @apiWrapper
     */
    protected $_endPointDescriptions = array(
        'authenticate' => array('method' => 'post', 'uriTemplate' => '/auth/1/session'),
        'getMyDetails' => array('method' => 'get', 'uriTemplate' => '/auth/1/session'),
        'getIssueDetails' => array('method' => 'get', 'uriTemplate' => '/api/2/issue/{issueIdOrKey}')
    );


    public function authenticate($username, $password)
    {
        $response = $this->_api(__FUNCTION__, array(
            'username' => $username,
            'password' => $password
        ));
        return $response;
    }

    public function getMyDetails()
    {
        return $this->_api(__FUNCTION__);
    }

    public function getIssueDetails($issueIdOrKey)
    {
        return $this->_api(__FUNCTION__, array(
            'issueIdOrKey' => $issueIdOrKey
        ));
    }

    protected function _api($endPointDescriptionName, $requestParameters = array())
    {
        $response = parent::_api($endPointDescriptionName, $requestParameters);
        try {
            $this->_checkHttpErrors();
        } catch (Exception $e) {
            $response->error = true;
            $response->reason = $e->getMessage();
        }
        return $response;
    }

    protected function _checkHttpErrors()
    {
        $headers = $this->getHttpResponseHeader();
        foreach ($headers as $header) {
            if (preg_match('/^HTTP\S*\s+4\d\d/', $header)) {
                throw new Exception('Jira is complaining.');
            }
        }
    }


}