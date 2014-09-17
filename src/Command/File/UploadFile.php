<?php namespace AdammBalogh\Box\Command\File;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use GuzzleHttp\Post\PostFile;

class UploadFile extends Command
{
    /**
     * @param string $fileName
     * @param string $parentFolderId
     * @param string $content
     */
    public function __construct($fileName, $parentFolderId, $content)
    {
        $postBody = new PostBody();
        $postBody->setField('parent_id', $parentFolderId);
        $postBody->addFile(new PostFile('filename', $content, $fileName));

        $this->request = new PostRequest('files/content');
        $this->request->setBody($postBody);
    }
}
