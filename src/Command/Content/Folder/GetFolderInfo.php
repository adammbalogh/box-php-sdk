<?php namespace AdammBalogh\Box\Command\Content\Folder;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetFolderInfo extends AbstractCommand
{
    /**
     * @param string $folderId
     */
    public function __construct($folderId)
    {
        $this->request = new GetRequest("folders/{$folderId}");
    }
}
