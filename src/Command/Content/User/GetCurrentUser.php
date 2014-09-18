<?php namespace AdammBalogh\Box\Command\Content\User;

use AdammBalogh\Box\Command\Command;
use AdammBalogh\Box\GuzzleHttp\Message\GetRequest;

class GetCurrentUser extends Command
{
    public function __construct()
    {
        $this->request = new GetRequest('users/me');
    }
}
