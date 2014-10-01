<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;
use GuzzleHttp\Post\PostBody;

class UpdateDocumentInfo extends AbstractCommand
{
    /**
     * @param string $documentId
     * @param string $name
     */
    public function __construct($documentId, $name)
    {
        $postBody = new PostBody();
        $postBody->setField('name', $name);

        $this->request = new PutRequest("documents/{$documentId}");
        $this->request->setRawJsonBody($postBody->getFields());
    }
}
