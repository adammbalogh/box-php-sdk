<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetFolderInfo extends Command
{
    public function __construct($folderId)
    {
        $this->request = new GetRequest("folders/{$folderId}");
    }
}
