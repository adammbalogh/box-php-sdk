<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class ListFolderCollaborations extends Command
{
    /**
     * @param string $folderId
     */
    public function __construct($folderId)
    {
        $this->request = new GetRequest("folders/{$folderId}/collaborations");
    }
}
