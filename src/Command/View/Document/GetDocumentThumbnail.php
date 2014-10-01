<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class GetDocumentThumbnail extends AbstractCommand
{
    /**
     * @param string $documentId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($documentId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new GetRequest("documents/{$documentId}/thumbnail");

        if (!is_null($extendedRequest)) {
            $this->request->setQuery($extendedRequest->getQuery());
        }
    }
}
