<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\Request;

class UpdateFolderInfo extends Command
{
    public function __construct($folderId, array $data)
    {
        $this->request = new Request('PUT', "folders/{$folderId}");
        $this->request->setRawJsonBody($data);
    }
}
