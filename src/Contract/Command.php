<?php namespace AdammBalogh\Box\Contract;

interface Command
{
    /**
     * @param \GuzzleHttp\Client $client
     * @throw \LogicException
     * @throw \GuzzleHttp\Exception\RequestException
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function execute(\GuzzleHttp\Client $client);
}
