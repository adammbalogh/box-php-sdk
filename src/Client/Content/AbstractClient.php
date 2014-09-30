<?php namespace AdammBalogh\Box\Client\Content;

use GuzzleHttp\Client as GuzzleClient;

abstract class AbstractClient extends GuzzleClient
{
    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;

        parent::__construct([
            'base_url' => [static::URI . '/{version}/', ['version' => static::API_VERSION]],
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]
        ]);
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
