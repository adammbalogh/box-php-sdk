<?php namespace AdammBalogh\Box\Command\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\DeleteRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class DeleteFile extends Command
{
    /**
     * @param string $fileId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($fileId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new DeleteRequest("files/{$fileId}");

        if (!is_null($extendedRequest)) {
            $this->request->addHeaders($extendedRequest->getHeaders());
        }
    }
}
