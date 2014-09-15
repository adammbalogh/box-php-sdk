<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

class PostRequest extends Request
{
    public function __construct($url, $headers = [], $body = null, array $options = [])
    {
        parent::__construct('POST', $url, $headers, $body, $options);
    }
}
