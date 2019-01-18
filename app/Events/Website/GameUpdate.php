<?php

namespace App\Events\Website;

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

    public $game;
    public $update;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Game $game, $update = [])
    {
        $game = \App\Model\Game::find($game->id);
        $this->game = [
            "id" => $game->id,
            "status" => $game->status,
            "options" => $game->getOptionsAsArray(),
            "board" => $game->id_board,
        ];
        $this->update = $update;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('game.'.$this->game["id"]);
    }
}
