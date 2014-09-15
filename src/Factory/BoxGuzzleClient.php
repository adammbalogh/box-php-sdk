<?php namespace AdammBalogh\Box\Factory;

use GuzzleHttp\Client as GuzzleClient;

class BoxGuzzleClient
{
    private static $baseUri = 'https://api.box.com';
    private static $version = '2.0';

    /**
     * @param string $accessToken
     * @return GuzzleClient
     */
    public static function getBoxGuzzleClient($accessToken)
    {
        return new GuzzleClient([
            'base_url' => [self::$baseUri . '/{version}/', ['version' => self::$version]],
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]
        ]);
    }
}
