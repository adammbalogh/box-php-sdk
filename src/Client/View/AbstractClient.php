<?php namespace AdammBalogh\Box\Client\View;

use GuzzleHttp\Client as GuzzleClient;

abstract class AbstractClient extends GuzzleClient
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;

        parent::__construct([
            'base_url' => [static::URI . '/{version}/', ['version' => static::API_VERSION]],
            'defaults' => [
                'headers' => ['Authorization' => 'Token ' . $apiKey],
            ]
        ]);
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
}
