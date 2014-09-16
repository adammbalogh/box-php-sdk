<?php namespace AdammBalogh\Box\Command\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class DownloadFile extends Command
{
    /**
     * @param int $fileId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($fileId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new GetRequest("files/{$fileId}/content");

        if (!is_null($extendedRequest)) {
            $this->request->setQuery($extendedRequest->getQuery());
        }
    }
}
