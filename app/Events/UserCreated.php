<?php

namespace App\Events;

class UserCreated extends Event
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
