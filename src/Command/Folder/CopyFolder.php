<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;

class CopyFolder extends Command
{
    /**
     * @param int $sourceFolderId
     * @param int $destinationFolderId
     */
    public function __construct($sourceFolderId, $destinationFolderId)
    {
        $postBody = new PostBody();
        $postBody->setField('parent', ['id' => $destinationFolderId]);

        $this->request = new PostRequest("folders/{$sourceFolderId}/copy");
        $this->request->setRawJsonBody($postBody->getFields());
    }
}
