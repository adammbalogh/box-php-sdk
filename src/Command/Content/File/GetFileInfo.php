<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetFileInfo extends Command
{
    /**
     * @param string $fileId
     */
    public function __construct($fileId)
    {
        $this->request = new GetRequest("files/{$fileId}");
    }
}
