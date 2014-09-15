<?php namespace AdammBalogh\Box\Contract;

interface Client
{
    /**
     * @param Command $command
     * @throw \LogicException
     * @throw \GuzzleHttp\Exception\RequestException
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function request(Command $command);
}
