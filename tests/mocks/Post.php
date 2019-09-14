<?php

namespace Subsession\Http\Tests\Mocks;

class Post
{
    private $id;

    private $title;

    private $body;

    private $userId;

    public function __construct()
    {
        $this->id = 1;
        $this->title = "Test title";
        $this->body = "Test body";
        $this->userId = 1;
    }
}
