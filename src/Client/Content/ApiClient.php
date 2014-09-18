<?php namespace AdammBalogh\Box\Client\Content;

use GuzzleHttp\Client as GuzzleClient;

class ApiClient extends GuzzleClient
{
    const URI = 'https://api.box.com';
    const VERSION = '2.0';

    private $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;

        parent::__construct([
            'base_url' => [self::URI . '/{version}/', ['version' => self::VERSION]],
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
