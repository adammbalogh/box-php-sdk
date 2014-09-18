<?php namespace AdammBalogh\Box\Factory\Content;

use GuzzleHttp\Client as GuzzleClient;
use AdammBalogh\Box;

class Client
{
    private static $baseUri = 'https://api.box.com';
    private static $uploadUri = 'https://upload.box.com/api';
    private static $version = '2.0';

    /**
     * @param string $accessToken
     * @return GuzzleClient
     */
    public static function getGuzzleClient($accessToken)
    {
        return new GuzzleClient([
            'base_url' => [self::$baseUri . '/{version}/', ['version' => self::$version]],
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]
        ]);
    }

    /**
     * @param string $accessToken
     * @return GuzzleClient
     */
    public static function getGuzzleUploadClient($accessToken)
    {
        return new GuzzleClient([
            'base_url' => [self::$uploadUri . '/{version}/', ['version' => self::$version]],
            'defaults' => [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]
        ]);
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return self::$version;
    }
}
