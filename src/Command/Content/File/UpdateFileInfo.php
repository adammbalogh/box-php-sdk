<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class UpdateFileInfo extends AbstractCommand
{
    /**
     * @param string $fileId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($fileId, ExtendedRequest $extendedRequest)
    {
        $this->request = new PutRequest("files/{$fileId}");

        $this->request->addHeaders($extendedRequest->getHeaders());
        $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
    }
}
