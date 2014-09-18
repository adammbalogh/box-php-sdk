<?php namespace AdammBalogh\Box\Contract;

use GuzzleHttp\Client as GuzzleClient;

interface CommandInterface
{
    /**
     * @param GuzzleClient $client
     *
     * @throw \LogicException
     * @throw \GuzzleHttp\Exception\RequestException
     *
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function execute(GuzzleClient $client);
}
