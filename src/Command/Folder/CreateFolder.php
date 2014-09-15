<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\Request;

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
        $this->request = new Request('POST', 'folders');
        $this->request->setRawJsonBody($data);
    }
}
