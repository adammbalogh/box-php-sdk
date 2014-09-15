<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

class DeleteRequest extends Request
{
    public function __construct($url, $headers = [], $body = null, array $options = [])
    {
        parent::__construct('DELETE', $url, $headers, $body, $options);
    }
}
