<?php namespace AdammBalogh\Box\Command\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\OptionsRequest;
use GuzzleHttp\Post\PostBody;

class PreFlightExistingFileCheck extends Command
{
    /**
     * @param string $fileId
     * @param int $fileSize
     */
    public function __construct($fileId, $fileSize)
    {
        $postBody = new PostBody();
        $postBody->setField('size', $fileSize);

        $this->request = new OptionsRequest("files/{$fileId}/content");
        $this->request->setRawJsonBody($postBody->getFields());
    }
}
