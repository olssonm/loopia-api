<?php

namespace Olssonm\LoopiaApi;

/**
 *
 */
class Client
{
    protected $username;

    protected $password;

    protected $rpcClient;

    const LOOPIA_API_ENDPOINT = 'https://api.loopia.se/RPCSERV';

    protected $response;

    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->rpcClient = new \fXmlRpc\Client(self::LOOPIA_API_ENDPOINT);
    }

    public function __call($method, $params = [])
    {
        $params = array_merge([$this->username, $this->password], $params);

        $this->response = $this->rpcClient->call($method, $params);

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
