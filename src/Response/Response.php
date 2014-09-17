<?php namespace AdammBalogh\Box\Response;

use GuzzleHttp\Message;
use AdammBalogh\Box\GuzzleHttp\Message\SuccessResponse;
use AdammBalogh\Box\GuzzleHttp\Message\ErrorResponse;

class Response
{
    /**
     * @var Message\Response
     */
    private $response;

    /**
     * @param Message\Response $response
     *
     * @throws \GuzzleHttp\Exception\ParseException
     */
    public function __construct(Message\Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return ErrorResponse|SuccessResponse
     */
    public function deduce()
    {
        /* @var array $response */
        $response = (array)$this->response->json();

        if (array_key_exists('type', $response) && $response['type'] === 'error') {
            return new ErrorResponse(
                $this->response->getStatusCode(),
                $this->response->getHeaders(),
                $this->response->getBody()
            );
        }

        return new SuccessResponse(
            $this->response->getStatusCode(),
            $this->response->getHeaders(),
            $this->response->getBody()
        );
    }
}
