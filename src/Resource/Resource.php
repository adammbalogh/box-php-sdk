<?php namespace AdammBalogh\Box\Resource;

use AdammBalogh\Box\Helper\ClassTrait;

abstract class Resource
{
    use ClassTrait
    {
        getClassName as protected;
    }

    protected function getName()
    {
        $name = $this->getClassName();

        if (property_exists($this, 'name')) {
            $name = $this->name;
        }

        return strtolower($name);
    }
}
