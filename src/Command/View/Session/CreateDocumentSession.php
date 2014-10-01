<?php namespace AdammBalogh\Box\Command\View\Session;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use AdammBalogh\Box\Request\ExtendedRequest;

class CreateDocumentSession extends AbstractCommand
{
    /**
     * @param string $documentId
     * @param ExtendedRequest $extendedRequest
     */
    public function __construct($documentId, ExtendedRequest $extendedRequest = null)
    {
        $postBody = new PostBody();
        $postBody->setField('document_id', $documentId);

        $postFields = $postBody->getFields();

        if (!is_null($extendedRequest)) {
            $postFields = array_merge($postFields, $extendedRequest->getPostBodyFields());
        }

        $this->request = new PostRequest('sessions');
        $this->request->setRawJsonBody($postFields);
    }
}
