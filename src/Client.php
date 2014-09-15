<?php namespace AdammBalogh\Box;

use AdammBalogh\Box\Contract;
use AdammBalogh\Box\Contract\Command;
use GuzzleHttp\Client as GuzzleClient;

class Client implements Contract\Client
{
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @param GuzzleClient $guzzleClient
     */
    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param Command $command
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function request(Command $command)
    {
        return $command->execute($this->guzzleClient);
    }

    /**
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }
}
