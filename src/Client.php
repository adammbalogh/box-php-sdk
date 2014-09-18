<?php namespace AdammBalogh\Box;

use AdammBalogh\Box\Contract;
use AdammBalogh\Box\Contract\CommandInterface;
use AdammBalogh\Box\Contract\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;

class Client implements ClientInterface
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
     * @param CommandInterface $command
     *
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function request(CommandInterface $command)
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
