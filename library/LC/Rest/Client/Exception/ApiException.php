<?php
namespace LC\Rest\Client\Exception;
use \Exception;

/**
 * Class ApiException
 *
 * types of exceptions (based on error code) that may occur during the consumption of Api Wrappers
 *
 * @author Lance Caraccioli <lance.caraccioli@gmail.com>
 */
class ApiException extends Exception
{

    /**
     * Error code used to indicate that an unknown error has occurred.
     */
    const UnknownError = 0;

    /**
     * Error code used to indicate that the API access token is missing for a request that requires an API access token
     */
    const AccessTokenMissing = 1;

    /**
     * Error code used to indicate that a network connection error occurred between the application and API
     */
    const NetworkConnectionError = 2;

    /**
     * Error code used to indicate that although the network request was successful the API reported an error
     */
    const ApiResponseError = 3;

    /**
     * Error code used to indicate that the client id, used to identify a client application, is missing.
     */
    const ClientIDMissing = 4;

    /**
     * Error code used to indicate that the client secret, used to identify a client application, is missing.
     */
    const ClientSecretMissing = 5;

    /**
     * Error code used to indicate that the supplied API access token for a user is invalid.
     */
    const AccessTokenInvalid = 6;

    /**
     * @var array
     */
    protected static $_errorMessages = array(
        self::ClientIDMissing => 'Missing client application id',
        self::ClientSecretMissing => 'Missing client application secret',
        self::AccessTokenMissing => 'Missing user API access token.',
        self::AccessTokenInvalid => 'The user\'s access token is invalid',
        self::ApiResponseError => 'The API responded with an error ({http_status_code}). Reason: {reason}',
        self::NetworkConnectionError => 'There was a network connection error ({http_status_code}) when communicating with the API.  Reason: {reason}',
        self::UnknownError => 'An unknown error has occurred in the  API Wrapper',
    );

    /**
     * @var
     */
    protected $_httpResponseHeaders;

    /**
     * @var
     */
    protected $_errorResponse;

    /**
     * @param null $errorCode
     * @param null $APIErrorResponse
     * @param null $http_response_header
     */
    public function __construct($errorCode = null, $APIErrorResponse = null, $httpResponseHeaders = null)
    {
        if (!empty($APIErrorResponse) && is_object($APIErrorResponse) && !empty($APIErrorResponse->reason)) {
            $this->setErrorResponse($APIErrorResponse);
        }
        if (!empty($httpResponseHeaders)) {
            $this->setHttpResponseHeaders($httpResponseHeaders);
        }
        if (empty(self::$_errorMessages[$errorCode])) {
            $errorCode = self::UnknownError;
        }
        $message = self::$_errorMessages[$errorCode];
        if ((self::ApiResponseError == $errorCode) || (self::NetworkConnectionError == $errorCode)) {
            $reason = !empty($APIErrorResponse->reason) ? $APIErrorResponse->reason : 'Unknown';
            preg_match('/HTTP[\S]*\s(\d*)/', $httpResponseHeaders[0], $httpStatusCodeMatches);
            $httpStatusCode = !empty($httpStatusCodeMatches[1]) ? $httpStatusCodeMatches[1] : 'Unknown';
            $message = str_replace('{reason}', $reason, $message);
            $message = str_replace('{http_status_code}', $httpStatusCode, $message);
        }
        parent::__construct($message, $errorCode);
    }

    /**
     * @param $http_response_header
     */
    public function setHttpResponseHeaders($http_response_header)
    {
        $this->_httpResponseHeaders = $http_response_header;
    }

    /**
     * @return mixed
     */
    public function getHttpResponseHeaders()
    {
        return $this->_httpResponseHeaders;
    }

    /**
     * @param $APIErrorResponse
     */
    public function setErrorResponse($APIErrorResponse)
    {
        $this->_errorResponse = $APIErrorResponse;
    }

    /**
     * @return mixed
     */
    public function getErrorResponse()
    {
        return $this->_errorResponse;
    }
}