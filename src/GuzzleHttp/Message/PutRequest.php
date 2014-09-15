<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

class PutRequest extends Request
{
    public function __construct($url, $headers = [], $body = null, array $options = [])
    {
        parent::__construct('PUT', $url, $headers, $body, $options);
    }
}
