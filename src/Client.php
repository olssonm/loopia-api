<?php

namespace Olssonm\LoopiaApi;

use fXmlRpc\Client as FXmlRpcClient;
use GuzzleHttp\Client as GuzzleHttpClient;

/**
 * Loopia API Client
 */
class Client
{
    /**
     * Username
     * @var string
     */
    protected $username;

    /**
     * Password
     * @var string
     */
    protected $password;

    /**
     * Main RPC-client
     * @var \fXmlRpc\Client
     */
    protected $rpcClient;

    /**
     * The response from a call
     * @var mixed
     */
    protected $response;

    /**
     * The Loopia end-point
     * @var string
     */
    const LOOPIA_API_ENDPOINT = 'https://api.loopia.se/RPCSERV';

    /**
     * Constructor
     * @param string $username
     * @param string $password
     */
    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $httpClient = new GuzzleHttpClient();

        $this->rpcClient = new FXmlRpcClient(
            self::LOOPIA_API_ENDPOINT,
            new \fXmlRpc\Transport\HttpAdapterTransport(
                new \Http\Message\MessageFactory\DiactorosMessageFactory(),
                new \Http\Adapter\Guzzle6\Client($httpClient)
            )
        );
    }

    /**
     * Magic __call-method
     * @param  string $method
     * @param  array  $params
     * @return \Olssonm\LoopiaApi\Client
     */
    public function __call($method, $params = [])
    {
        $params = array_merge([$this->username, $this->password], $params);

        $this->response = $this->rpcClient->call($method, $params);

        return $this;
    }

    /**
     * Retrieve the response from the latest call
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
