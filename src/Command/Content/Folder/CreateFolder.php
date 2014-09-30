<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;

class CreateFolder extends AbstractCommand
{
    /**
     * @param string $folderName
     * @param string $parentFolderId
     */
    public function __construct($folderName, $parentFolderId)
    {
        $postBody = new PostBody();
        $postBody->setField('name', $folderName);
        $postBody->setField('parent', ['id' => $parentFolderId]);

        $this->request = new PostRequest('folders');
        $this->request->setRawJsonBody((array)$postBody->getFields());
    }
}
