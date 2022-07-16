<?php

namespace App\Events\Shop;

use App\Models\Shop\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskFailedPush implements ShouldBroadcastNow //ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Task $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->task = $task;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel
     */
    public function broadcastOn(): Channel|PrivateChannel
    {
        return new PrivateChannel('tasks.17');
    }
}
