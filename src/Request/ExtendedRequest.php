<?php namespace AdammBalogh\Box\Request;

use GuzzleHttp\Query;

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
     * @var array
     */
    private $bodyFields = [];

    public function __construct()
    {
        $this->query = new Query();
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($name, $value)
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
    public function addQuery($name, $value)
    {
        $this->query->add($name, $value);
        return $this;
    }

    /**
     * @param Query $query
     *
     * @return $this
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;
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
     * @param $value
     *
     * @return $this
     */
    public function addBodyField($name, $value)
    {
        $this->bodyFields[$name] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getBodyFields()
    {
        return $this->bodyFields;
    }

    /**
     * @param array $mergeWithData
     *
     * @return array
     */
    public function getMergedBodyFields(array $mergeWithData)
    {
        return array_merge($this->bodyFields, $mergeWithData);
    }
}
