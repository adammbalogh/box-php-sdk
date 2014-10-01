<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use GuzzleHttp\Post\PostFile;
use AdammBalogh\Box\Request\ExtendedRequest;

class MultipartDocumentUpload extends AbstractCommand
{
    /**
     * @param string $content
     * @param string $fileName
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($content, $fileName, ExtendedRequest $extendedRequest = null)
    {
        $postBody = new PostBody();
        $this->request = new PostRequest('documents');

        if (!is_null($extendedRequest)) {
            $postBody = $extendedRequest->getPostBody();
        }

        $postBody->addFile(new PostFile('file', $content, $fileName));
        $this->request->setBody($postBody);
    }
}
