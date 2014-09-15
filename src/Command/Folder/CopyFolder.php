<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;

class CopyFolder extends Command
{
    public function __construct($sourceFolderId, $destinationFolderId)
    {
        $data = [
            'parent' => [
                'id' => $destinationFolderId
            ]
        ];
        $this->request = new PostRequest("folders/{$sourceFolderId}/copy");
        $this->request->setRawJsonBody($data);
    }
}
