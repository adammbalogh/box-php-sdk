<?php namespace AdammBalogh\Box\Command\Content\User;

use AdammBalogh\Box\Command\AbstractCommand;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetCurrentUser extends AbstractCommand
{
    public function __construct()
    {
        $this->request = new GetRequest('users/me');
    }
}
