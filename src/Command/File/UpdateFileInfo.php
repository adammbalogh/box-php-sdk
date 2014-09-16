<?php namespace AdammBalogh\Box\Command\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class UpdateFileInfo extends Command
{
    public function __construct($fileId, ExtendedRequest $extendedRequest)
    {
        $this->request = new PutRequest("files/{$fileId}");

        $this->request->addHeaders($extendedRequest->getHeaders());
        $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
    }
}
