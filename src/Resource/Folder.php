<?php namespace AdammBalogh\Box\Resource;

class Folder extends Resource
{
    protected $name = 'folders';
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}
