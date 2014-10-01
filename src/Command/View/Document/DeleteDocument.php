<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\DeleteRequest;

class DeleteDocument extends AbstractCommand
{
    /**
     * @param string $documentId
     */
    public function __construct($documentId)
    {
        $this->request = new DeleteRequest("documents/{$documentId}");
    }
}
