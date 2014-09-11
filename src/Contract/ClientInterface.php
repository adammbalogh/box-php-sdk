<?php namespace AdammBalogh\Box\Contract;

use AdammBalogh\Box\Resource\Resource;

interface ClientInterface
{
    public function create(Resource $resource);
}
