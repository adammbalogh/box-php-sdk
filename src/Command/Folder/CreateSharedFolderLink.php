<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class CreateSharedFolderLink extends Command
{
    /**
     * @param string $folderId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($folderId, ExtendedRequest $extendedRequest)
    {
        $this->request = new PutRequest("folders/{$folderId}");

        $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
    }
}
