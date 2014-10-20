<?php namespace AdammBalogh\Box\Wrapper;

use AdammBalogh\Box\ContentClient;
use AdammBalogh\Box\Command\Content\Search\SearchContent;
use AdammBalogh\Box\Exception\FileNotFoundException;
use AdammBalogh\Box\Exception\FolderNotFoundException;
use AdammBalogh\Box\Request\ExtendedRequest;
use AdammBalogh\Box\Factory\ResponseFactory;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\Wrapper\Response\Entry;
use AdammBalogh\Box\Wrapper\Response\FileEntry;
use AdammBalogh\Box\Wrapper\Response\FolderEntry;

class SearchPath
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
     * @param string $path
     *
     * @return FileEntry|FolderEntry
     *
     * @throws FileNotFoundException
     * @throws FolderNotFoundException
     * @throws \Exception
     */
    public function getEntry($path)
    {
        $entry = new Entry();
        $path = trim(preg_replace('#/+#', '/', $path), '/');

        if (empty($path)) {
            $entry = new FolderEntry();
            $entry->identity = self::ROOT_DIR_ID;

            return $entry;
        }

        $response = $this->getSearchResponse($path);

        if ($response instanceof SuccessResponse) {
            $entry = $this->getEntryObject($response, $path);
        } elseif ($response instanceof ErrorResponse) {
            throw new \Exception($response->getStatusCode() . (string)$response->getBody());
        }

        return $entry;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param string $path
     *
     * @return ErrorResponse|SuccessResponse
     */
    protected function getSearchResponse($path)
    {
        $extendedRequest = new ExtendedRequest();
        $extendedRequest->addQueryField('content_types', 'name');
        $extendedRequest->addQueryField('limit', 20);

        $command = new SearchContent(basename($path), $extendedRequest);

        return ResponseFactory::getResponse($this->contentClient, $command);
    }

    /**
     * @param SuccessResponse $response
     * @param string $path
     *
     * @return FileEntry|FolderEntry
     *
     * @throws FileNotFoundException
     * @throws FolderNotFoundException
     * @throws \Exception
     */
    protected function getEntryObject(SuccessResponse $response, $path)
    {
        $result = new Entry();

        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getStatusCode() . (string)$response->getBody());
        }

        foreach ($response->json()['entries'] as $entry) {
            if ($this->getEntryPath($entry) === $path) {

                if ($entry['type'] === 'file') {
                    $result = new FileEntry();
                } elseif ($entry['type'] === 'folder') {
                    $result = new FolderEntry();
                }

                $result->identity = $entry['id'];
                break;
            }
        }

        if (is_null($result->identity)) {
            if ($result instanceof FileEntry) {
                throw new FileNotFoundException($path);
            }

            throw new FolderNotFoundException($path);
        }

        return $result;
    }

    /**
     * @param array $entry
     *
     * @return string
     */
    protected function getEntryPath(array $entry)
    {
        $path = '';

        foreach ($entry['path_collection']['entries'] as $folder) {
            if ($folder['id'] == self::ROOT_DIR_ID) {
                continue;
            }

            $path .= $folder['name'] . '/';
        }

        $path .= $entry['name'];

        return $path;
    }
}
