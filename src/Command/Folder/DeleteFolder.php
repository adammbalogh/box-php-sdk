<?php namespace AdammBalogh\Box\Command\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\Request;

class DeleteFolder extends Command
{
    public function __construct($folderId)
    {
        $this->request = new Request('DELETE', "folders/{$folderId}");
    }
}
