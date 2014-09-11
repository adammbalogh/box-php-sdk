<?php namespace AdammBalogh\Box\Builder;

use AdammBalogh\Box\Contract\ClientInterface;
use AdammBalogh\Box\Resource\Resource;

class RequestBuilder
{
    private $client;
    private $resource;

    public function __construct(ClientInterface $client, Resource $resource)
    {
        $this->client = $client;
        $this->resource = $resource;
    }
}
