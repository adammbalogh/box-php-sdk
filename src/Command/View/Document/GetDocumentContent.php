<?php namespace AdammBalogh\Box\Command\View\Document;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetDocumentContent extends AbstractCommand
{
    /**
     * @param string $documentId
     * @param string $extension can be empty string, 'pdf' or 'zip'
     */
    public function __construct($documentId, $extension = '')
    {
        if ($extension !== '') {
            $extension = ".{$extension}";
        }

        $this->request = new GetRequest("documents/{$documentId}/content{$extension}");
    }
}
