<?php

namespace App\Listeners;

use App\Jobs\UserCreated as UserCreatedJob;
use Illuminate\Support\Facades\Queue;

class UserCreated
{
    private $queue_name = "user-created";

    public function __construct()
    {
    }

    public function handle($event)
    {
        Queue::push(new UserCreatedJob($event->data), $event->data, $this->queue_name);
    }
}
