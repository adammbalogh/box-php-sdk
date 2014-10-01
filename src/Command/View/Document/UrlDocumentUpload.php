<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use AdammBalogh\Box\Request\ExtendedRequest;

class UrlDocumentUpload extends AbstractCommand
{
    /**
     * @param string $url
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($url, ExtendedRequest $extendedRequest = null)
    {
        $postBody = new PostBody();
        $postBody->setField('url', $url);

        $postFields = $postBody->getFields();

        if (!is_null($extendedRequest)) {
            $postFields = array_merge($postFields, $extendedRequest->getPostBodyFields());
        }

        $this->request = new PostRequest('documents');
        $this->request->setRawJsonBody($postFields);
    }
}
