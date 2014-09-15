<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\Request;

class CopyFolder extends Command
{
    public function __construct($sourceFolderId, $destinationFolderId)
    {
        $data = [
            'parent' => [
                'id' => $destinationFolderId
            ]
        ];
        $this->request = new Request('POST', "folders/{$sourceFolderId}/copy");
        $this->request->setRawJsonBody($data);
    }
}
