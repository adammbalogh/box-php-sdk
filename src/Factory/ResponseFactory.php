<?php namespace AdammBalogh\Box\Factory;

use AdammBalogh\Box\Response\Response;
use AdammBalogh\Box\Contract\ClientInterface;
use AdammBalogh\Box\Contract\CommandInterface;

class ResponseFactory
{
    /**
     * @param ClientInterface $client
     * @param CommandInterface $command
     *
     * @return \AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse|\AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse
     */
    public static function getResponse(ClientInterface $client, CommandInterface $command)
    {
        return (new Response($client->request($command)))->deduce();
    }
}
