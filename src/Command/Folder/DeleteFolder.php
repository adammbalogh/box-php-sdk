<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\DeleteRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class DeleteFolder extends Command
{
    public function __construct($folderId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new DeleteRequest("folders/{$folderId}");

        if (!is_null($extendedRequest)) {
            $this->request->addHeaders($extendedRequest->getHeaders());
            $this->request->setQuery($extendedRequest->getQuery());
        }
    }
}
