<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class ListDocument extends AbstractCommand
{
    /**
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct(ExtendedRequest $extendedRequest = null)
    {
        $this->request = new GetRequest('documents');

        if (!is_null($extendedRequest)) {
            $this->request->setQuery($extendedRequest->getQuery());
        }
    }
}
