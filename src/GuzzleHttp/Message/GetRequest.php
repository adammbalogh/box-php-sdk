<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

class GetRequest extends Request
{
    public function __construct($url, $headers = [], $body = null, array $options = [])
    {
        parent::__construct('GET', $url, $headers, $body, $options);
    }
}
