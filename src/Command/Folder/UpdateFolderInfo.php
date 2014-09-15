<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PutRequest;

class UpdateFolderInfo extends Command
{
    public function __construct($folderId, array $data)
    {
        $this->request = new PutRequest("folders/{$folderId}");
        $this->request->setRawJsonBody($data);
    }
}
