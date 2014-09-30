<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\DeleteRequest;
use AdammBalogh\Box\Request\ExtendedRequest;

class DeleteFile extends AbstractCommand
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
