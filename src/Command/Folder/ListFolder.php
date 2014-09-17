<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class ListFolder extends Command
{
    /**
     * @param string $folderId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($folderId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new GetRequest("folders/{$folderId}/items");

        if (!is_null($extendedRequest)) {
            $this->request->setQuery($extendedRequest->getQuery());
        }
    }
}
