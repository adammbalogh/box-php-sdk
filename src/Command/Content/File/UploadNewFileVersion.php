<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use GuzzleHttp\Post\PostFile;
use AdammBalogh\Box\Request\ExtendedRequest;

class UploadNewFileVersion extends AbstractCommand
{
    /**
     * @param string $fileId
     * @param string $content
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($fileId, $content, ExtendedRequest $extendedRequest = null)
    {
        $postBody = new PostBody();
        $postBody->addFile(new PostFile('filename', $content));

        $this->request = new PostRequest("files/{$fileId}/content");
        $this->request->setBody($postBody);

        if (!is_null($extendedRequest)) {
            $this->request->addHeaders($extendedRequest->getHeaders());
            $this->request->setRawJsonBody($extendedRequest->getPostBodyFields());
        }
    }
}
