<?php namespace AdammBalogh\Box\GuzzleHttp\Message;

use GuzzleHttp\Stream\Stream;

class Request extends \GuzzleHttp\Message\Request
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param string $body
     *
     * @return $this
     */
    public function setRawBody($body)
    {
        $this->setBody(Stream::factory($body));
        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param array $data
     *
     * @return $this
     */
    public function setRawJsonBody(array $data)
    {
        $this->setBody(Stream::factory(json_encode($data)), 'application/json');
        return $this;
    }
}
