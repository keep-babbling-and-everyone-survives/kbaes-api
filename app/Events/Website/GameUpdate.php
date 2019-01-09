<?php

namespace App\Events\Website;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $game;
    public $ruleset;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(App\Game $game, App\Rule_Set $ruleset)
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
        return new PrivateChannel('game.'.$this->game->id);
    }
}
