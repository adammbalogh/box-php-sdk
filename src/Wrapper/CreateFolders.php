<?php namespace AdammBalogh\Box\Wrapper;

use AdammBalogh\Box\Command\Content\Folder\CreateFolder;
use AdammBalogh\Box\ContentClient;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;

class CreateFolders
{
    const ROOT_DIR_ID = 0;

    /**
     * @var ContentClient
     */
    private $contentClient;

    /**
     * @param ContentClient $contentClient
     */
    public function __construct(ContentClient $contentClient)
    {
        $this->contentClient = $contentClient;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param string $path
     *
     * @return string last folder's id
     *
     * @throws \Exception
     */
    public function create($path)
    {
        $folders = explode('/', trim(preg_replace('#/+#', '/', $path), '/'));
        $lastFolderId = self::ROOT_DIR_ID;

        foreach ($folders as $name) {

            $command = new CreateFolder($name, $lastFolderId);
            $response = ResponseFactory::getResponse($this->contentClient, $command);

            if ($response instanceof SuccessResponse) {

                if ($response->getStatusCode() == 201) {
                    $lastFolderId = $response->json()['id'];
                    usleep(250);
                    continue;
                }

            } elseif ($response instanceof ErrorResponse) {

                if ($response->getStatusCode() == 409) {
                    $lastFolderId = reset($response->json()['context_info']['conflicts'])['id'];
                    usleep(250);
                    continue;
                }

                throw new \Exception($response->getStatusCode() . (string)$response->getBody());
            }
        }

        if (is_null($lastFolderId)) {
            throw new \Exception();
        }

        return $lastFolderId;
    }
}
