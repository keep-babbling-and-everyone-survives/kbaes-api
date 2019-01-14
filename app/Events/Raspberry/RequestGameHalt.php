<?php

namespace App\Events\Raspberry;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RequestGameHalt implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    private $boardId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Game $game)
    {
        $this->game = [
            "id" => $game->id,
        ];
        $this->boardId = $game->id_board;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('board.'.$this->boardId);
    }
}
