<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;

class CopyFolder extends AbstractCommand
{
    /**
     * @param string $sourceFolderId
     * @param string $destinationFolderId
     */
    public function __construct($sourceFolderId, $destinationFolderId)
    {
        $postBody = new PostBody();
        $postBody->setField('parent', ['id' => $destinationFolderId]);

        $this->request = new PostRequest("folders/{$sourceFolderId}/copy");
        $this->request->setRawJsonBody((array)$postBody->getFields());
    }
}
