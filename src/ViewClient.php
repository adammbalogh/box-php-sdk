<?php namespace AdammBalogh\Box;

use AdammBalogh\Box\Command\View\Document\MultipartDocumentUpload;
use AdammBalogh\Box\Contract\CommandInterface;
use AdammBalogh\Box\Contract\ClientInterface;
use AdammBalogh\Box\Client\View\ApiClient;
use AdammBalogh\Box\Client\View\UploadClient;

class ViewClient implements ClientInterface
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var UploadClient
     */
    private $uploadClient;

    /**
     * @param ApiClient $apiClient
     * @param UploadClient $uploadClient
     */
    public function __construct(ApiClient $apiClient, UploadClient $uploadClient)
    {
        $this->apiClient = $apiClient;
        $this->uploadClient = $uploadClient;
    }

    /**
     * @param CommandInterface $command
     *
     * @throw \LogicException
     * @throw \GuzzleHttp\Exception\RequestException
     *
     * @return \GuzzleHttp\Message\ResponseInterface|void
     */
    public function request(CommandInterface $command)
    {
        if ($command instanceof MultipartDocumentUpload) {
            return $command->execute($this->uploadClient);
        }

        return $command->execute($this->apiClient);
    }
}
