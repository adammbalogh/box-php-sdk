<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;

class CreateFolder extends Command
{
    /**
     * @param string $folderName
     * @param int $parentFolderId
     */
    public function __construct($folderName, $parentFolderId = 0)
    {
        $postBody = new PostBody();
        $postBody->setField('name', $folderName);
        $postBody->setField('parent', ['id' => $parentFolderId]);

        $this->request = new PostRequest('folders');
        $this->request->setRawJsonBody($postBody->getFields());
    }
}
