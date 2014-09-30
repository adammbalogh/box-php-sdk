<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\OptionsRequest;
use GuzzleHttp\Post\PostBody;

class PreFlightExistingFileCheck extends AbstractCommand
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
        $this->request->setRawJsonBody((array)$postBody->getFields());
    }
}
