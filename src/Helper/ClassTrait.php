<?php namespace AdammBalogh\Box\Helper;

trait ClassTrait
{
    public function getClassName()
    {
        return join('', array_slice(explode('\\', get_class($this)), -1));
    }
}
