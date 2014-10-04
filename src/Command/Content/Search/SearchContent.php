<?php namespace AdammBalogh\Box\Command\Content\Search;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class SearchContent extends AbstractCommand
{
    /**
     * @param string $query
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($query, ExtendedRequest $extendedRequest = null)
    {
        $extendedRequest = is_null($extendedRequest) ? new ExtendedRequest() : $extendedRequest;
        $extendedRequest->addQueryField('query', $query);

        $this->request = new GetRequest('search');

        $this->request->setQuery($extendedRequest->getQuery());
    }
}
