<?php

namespace App\Events\Website;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameCreatedSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private $game_ID;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($game_ID)
    {
        $this->game_ID = $game_ID;
        //send notification of game created success
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('game.' . $this->game_ID);
    }
}
