<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\DeleteRequest;

class DeleteFolder extends Command
{
    public function __construct($folderId)
    {
        $this->request = new DeleteRequest("folders/{$folderId}");
    }
}
