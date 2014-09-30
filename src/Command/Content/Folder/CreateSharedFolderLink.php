<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class CreateSharedFolderLink extends AbstractCommand
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
