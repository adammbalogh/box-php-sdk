<?php namespace AdammBalogh\Box\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use \AdammBalogh\Box\Contract;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractCommand implements Contract\CommandInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Client $client
     *
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function execute(Client $client)
    {
        if (!$this->request instanceof Request) {
            throw new \InvalidArgumentException('request is not an instanceof \GuzzleHttp\Message\Request');
        }

        $this->copyClientDefaults($client);

        return $client->send($this->request);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Client $client
     */
    protected function copyClientDefaults(Client $client)
    {
        $this->request->setUrl($client->getBaseUrl() . $this->request->getUrl());
        $this->request->addHeaders($client->getDefaultOption('headers'));
    }
}
