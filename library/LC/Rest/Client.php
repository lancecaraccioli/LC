<?php
namespace LC\Rest;

/**
 * Class Client
 *
 * The class is intended base implementation of the template endpoint templates concept.
 *
 * As this file changes it should contain the minimal, yet comprehensive, feature set implementation
 * of REST clients.
 *
 * @TODO refactor extract basic REST operations into another class.
 * @TODO refactor to use basic REST operations per class created by above TODO
 * @TODO Rename this class to more explicitly indicate the concept this class implements (end point descriptions)
 *
 * Composite is
 * the preferred designe pattern for use of this class
 * end point description based rest client.
 * which also implements the common rest client features.
 * features of most rest clients.
 *
 * @author Lance Caraccioli <lance.caraccioli@gmail.com>
 */
class Client
{
    protected $_baseUri;
    protected $_httpResponseHeader;
    protected $_cookieString;
    protected $_response;
    protected $_debug = false;
    protected $_debugUri;
    /**
     * Used to store endpoint description data
     *
     * $_endPointDescriptions['endPointDescriptionName']=array('method'=>'[post|get|put|delete]','uriTemplate'=>'/example/{templateParameterName}');
     *
     * @var array
     */
    protected $_endPointDescriptions = array();

    public function __construct($baseUri)
    {
        $this->_setBaseUri($baseUri);
    }

    /**
     * @param mixed $baseUri
     */
    protected function _setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
    }

    public function addEndPointDescription($endPointDescriptionName, $endPointMethod, $endPointUriTemplate)
    {
        $this->_endPointDescriptions[$endPointDescriptionName] = array('method' => $endPointMethod, 'uriTemplate' => $endPointUriTemplate);
    }

    /**
     * Used to build the endpoint uri
     *
     * Used to build the endpoint uri based on the local api endpoint template key, the request parameters passed to this method
     *
     * @param $endPointDescriptionName the local api end point template key
     * @param array $requestParameters associative array in which the key represents the request parameter name and the value represents the request parameter value
     * @return string template uri segment populated with the request data.
     */
    protected function _getEndPointUri($endPointDescriptionName, $requestParameters = array())
    {
        //merge the general parameters needed for most requests
        $endPointDescription = $this->_getEndPointDescription($endPointDescriptionName);
        $endPointUriTemplate = $endPointDescription['uriTemplate'];
        $uri = $this->getBaseUri() . $this->_prepareUri($endPointUriTemplate, $requestParameters);
        return $uri;
    }

    /**
     * Use to get the endpoint template based on local key name
     *
     * @param $key the endpoint template key
     *
     * @return string the endpoint template url
     * @throws Exception if the requested end point template doesn't exist
     */
    protected function _getEndPointDescription($endPointDescriptionName)
    {
        if (empty($this->_endPointDescriptions[$endPointDescriptionName])) {
            throw new Exception ("Endpoint description ($endPointDescriptionName) not defined.");
        }
        return $this->_endPointDescriptions[$endPointDescriptionName];
    }

    /**
     * @return mixed
     */
    public function getBaseUri()
    {
        return $this->_baseUri;
    }

    /**
     * @param $uri
     * @param $requestParameters
     * @return string populated uri
     */
    protected function _prepareUri($uriTemplate, $requestParameters = array())
    {

        foreach ($requestParameters as $key => $value) {
            $uriTemplate = str_replace('{' . $key . '}', $value, $uriTemplate);
        }
        return $uriTemplate;
    }

    protected function _getEndPointMethod($endPointDescriptionName)
    {
        $endPointDescription = $this->_getEndPointDescription($endPointDescriptionName);
        return $endPointDescription['method'];
    }

    protected function _setResponse($response)
    {
        $this->_response = $response;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    protected function _setHttpResponseHeader($httpResponseHeader)
    {
        $this->_httpResponseHeader = $httpResponseHeader;
    }

    public function getHttpResponseHeader()
    {
        return $this->_httpResponseHeader ? : array();
    }

    public function getCookieHeader()
    {
        $cookieString = $this->getCookieString();
        return !empty($cookieString) ? "Cookie: $cookieString\n" : '';
    }

    protected function _setCookieString($cookie)
    {
        $this->_cookieString = $cookie;
    }

    public function getCookieString()
    {
        if (empty($this->_cookieString)) {
            $cookies = array();
            foreach ($this->getHttpResponseHeader() as $header) {
                if (false !== strpos($header, 'Set-Cookie')) {
                    $cookies[] = str_replace('Set-Cookie: ', '', $header);
                }
            }
            $this->_cookieString = implode('; ', $cookies);
        }
        return $this->_cookieString;
    }


    protected function _post($uri, $requestParameters = array())
    {
        $streamDescription = array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                "Content-Type: application/json\n" .
                "Accept: application/json\n" .
                $this->getCookieHeader(),
                'content' => json_encode($requestParameters),
                'ignore_errors' => true
            )
        );

        $streamContext = stream_context_create($streamDescription);
        $response = file_get_contents($uri, false, $streamContext);
        $response = $response ? json_decode($response) : array();
        $this->_setHttpResponseHeader($http_response_header);

        return $response;
    }

    protected function _put($uri, $requestParameters = array())
    {
        $streamDescription = array(
            'http' => array(
                'method' => 'PUT',
                'header' =>
                "Content-Type: application/json\n" .
                "Accept: application/json\n" .
                $this->getCookieHeader(),
                'content' => json_encode($requestParameters),
                'ignore_errors' => true
            )
        );
        $streamContext = stream_context_create($streamDescription);
        $response = file_get_contents($uri, false, $streamContext);
        $response = $response ? json_decode($response) : array();
        $this->_setHttpResponseHeader($http_response_header);

        return $response;
    }


    protected function _get($uri)
    {
        $streamDescription = array(
            'http' => array(
                'method' => 'GET',
                'header' =>
                "Accept: application/json\n" .
                $this->getCookieHeader(),
                'ignore_errors' => true
            )
        );

        $streamContext = stream_context_create($streamDescription);
        $response = file_get_contents($uri, false, $streamContext);
        $response = $response ? json_decode($response) : array();
        $response->request = $streamDescription;
        $this->_setHttpResponseHeader($http_response_header);

        return $response;
    }

    protected function _delete($uri)
    {
        $streamDescription = array(
            'http' => array(
                'method' => 'DELETE',
                'header' =>
                "Accept: application/json\n" .
                $this->getCookieHeader(),
                'ignore_errors' => true
            )
        );
        $streamContext = stream_context_create($streamDescription);
        $response = file_get_contents($uri, false, $streamContext);
        $response = $response ? json_decode($response) : array();
        $this->_setHttpResponseHeader($http_response_header);

        return $response;
    }

    public function setDebugUri($uri)
    {
        return $this->_debugUri = $uri;
    }

    public function getDebugUri()
    {
        return $this->_debugUri;
    }

    public function setDebug($shouldDebug)
    {
        $this->_debug = $shouldDebug;
    }

    public function getDebug()
    {
        return $this->_debug;
    }

    protected function _api($endPointDescriptionName, $requestParameters = array())
    {
        $uri = $this->_getEndPointUri($endPointDescriptionName, $requestParameters);
        if ($this->getDebug()) {
            $uri = $this->getDebugUri();
        }
        $method = "_" . strtolower($this->_getEndPointMethod($endPointDescriptionName));
        $response = $this->$method($uri, $requestParameters);
        $response->requestUri = $uri;
        $response->requestMethod = $method;
        $response->responseHeaders = $this->getHttpResponseHeader();
        $this->_setResponse($response);
        return $response;
    }
}