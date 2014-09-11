<?php namespace AdammBalogh\Box;

use AdammBalogh\Box\Builder\RequestBuilder;
use AdammBalogh\Box\Contract\ClientInterface;
use AdammBalogh\Box\Resource\Resource;

class Client implements ClientInterface
{
    private $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function create(Resource $resource)
    {
        new RequestBuilder($this, $resource);
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
