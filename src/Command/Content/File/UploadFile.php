<?php namespace AdammBalogh\Box\Command\Content\File;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\PostRequest;
use GuzzleHttp\Post\PostBody;
use GuzzleHttp\Post\PostFile;

class UploadFile extends AbstractCommand
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
