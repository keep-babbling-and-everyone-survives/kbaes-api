<?php

namespace App\Events\Raspberry;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $game;
    public $ruleset;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Game $game, \App\Model\Rule_Set $ruleset)
    {
        $this->game = [
            "id" => $game->id,
            "status" => $game->status,
            "board" => $game->id_board,
        ];
        $this->ruleset = $ruleset;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("board.".$this->game["board"]);
    }
}
