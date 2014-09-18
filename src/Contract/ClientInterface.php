<?php namespace AdammBalogh\Box\Contract;

interface ClientInterface
{
    /**
     * @param CommandInterface $command
     *
     * @throw \LogicException
     * @throw \GuzzleHttp\Exception\RequestException
     *
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function request(CommandInterface $command);
}
