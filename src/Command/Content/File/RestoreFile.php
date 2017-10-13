<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use AdammBalogh\Box\Request\ExtendedRequest;
use GuzzleHttp\Post\PostBody;

class RestoreFile extends AbstractCommand
{

    /**
     * RestoreFile constructor.
     * @param $fileId
     * @param ExtendedRequest|null $extendedRequest
     */
    public function __construct($fileId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new PostRequest("files/{$fileId}");

        if ($extendedRequest) {
            $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
        }
    }
}
