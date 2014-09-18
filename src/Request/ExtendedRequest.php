<?php namespace AdammBalogh\Box\Request;

use GuzzleHttp\Post\PostFileInterface;
use GuzzleHttp\Query;
use GuzzleHttp\Post\PostBody;

class ExtendedRequest
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var Query
     */
    private $query;

    /**
     * @var PostBody
     */
    private $postBody;

    public function __construct()
    {
        $this->query = new Query();
        $this->postBody = new PostBody();
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function addQueryField($name, $value)
    {
        $this->query->add($name, $value);
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setQueryField($name, $value)
    {
        $this->query->set($name, $value);
        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $name
     * @param array|string $value
     *
     * @return $this
     */
    public function setPostBodyField($name, $value)
    {
        $this->postBody->setField($name, $value);
        return $this;
    }

    /**
     * @param PostFileInterface $file
     *
     * @return $this
     */
    public function addPostBodyFile(PostFileInterface $file)
    {
        $this->postBody->addFile($file);
        return $this;
    }

    /**
     * @return array
     */
    public function getPostBodyFields()
    {
        return (array)$this->postBody->getFields();
    }


    /**
     * @return PostBody
     */
    public function getPostBody()
    {
        return $this->postBody;
    }
}
