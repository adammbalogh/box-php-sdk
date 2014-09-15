<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

use GuzzleHttp\Stream\Stream;

class Request extends \GuzzleHttp\Message\Request
{
    /**
     * @param string $body
     * @return $this
     */
    public function setRawBody($body)
    {
        $this->setBody(Stream::factory($body));
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setRawJsonBody(array $data)
    {
        $this->setRawBody(json_encode($data));
        return $this;
    }
}
