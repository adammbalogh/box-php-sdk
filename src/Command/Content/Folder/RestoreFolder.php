<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use AdammBalogh\Box\Request\ExtendedRequest;
use GuzzleHttp\Post\PostBody;

class RestoreFolder extends AbstractCommand
{
    /**
     * @param string $folderId
     * @param ExtendedRequest|null $extendedRequest
     */
    public function __construct($folderId, ExtendedRequest $extendedRequest = null)
    {
        $this->request = new PostRequest("folders/{$folderId}");

        if ($extendedRequest) {
            $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
        }
    }
}
