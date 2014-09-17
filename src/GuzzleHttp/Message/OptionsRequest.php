<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

class OptionsRequest extends Request
{
    public function __construct($url, $headers = [], $body = null, array $options = [])
    {
        parent::__construct('OPTIONS', $url, $headers, $body, $options);
    }
}
