<?php namespace AdammBalogh\Box;

class Client
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function get_access_token()
    {
        return $this->accessToken;
    }
}
