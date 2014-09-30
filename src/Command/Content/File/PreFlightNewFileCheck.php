<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\OptionsRequest;
use GuzzleHttp\Post\PostBody;

class PreFlightNewFileCheck extends AbstractCommand
{
    /**
     * @param string $fileName
     * @param int $fileSize
     * @param string $parentFolderId
     */
    public function __construct($fileName, $fileSize, $parentFolderId)
    {
        $postBody = new PostBody();
        $postBody->setField('name', $fileName);
        $postBody->setField('size', $fileSize);
        $postBody->setField('parent', ['id' => $parentFolderId]);

        $this->request = new OptionsRequest('files/content');
        $this->request->setRawJsonBody((array)$postBody->getFields());

    }
}
