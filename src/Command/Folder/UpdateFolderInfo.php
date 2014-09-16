<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class UpdateFolderInfo extends Command
{
    public function __construct($folderId, ExtendedRequest $extendedRequest)
    {
        $this->request = new PutRequest("folders/{$folderId}");

        $this->request->addHeaders($extendedRequest->getHeaders());
        $this->request->setRawJsonBody($extendedRequest->getBodyFields());
    }
}
