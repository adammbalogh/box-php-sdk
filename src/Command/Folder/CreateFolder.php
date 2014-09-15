<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;

class CreateFolder extends Command
{
    public function __construct($folderName, $parentFolderId = 0)
    {
        $data = [
            'name' => $folderName,
            'parent' => [
                'id' => $parentFolderId
            ]
        ];
        $this->request = new PostRequest('folders');
        $this->request->setRawJsonBody($data);
    }
}
