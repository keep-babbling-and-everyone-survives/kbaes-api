<?php

namespace App\Events\Raspberry;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RequestNewGame implements ShouldBroadcast
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
        $usedModules = [];
        foreach($game->rulesets as $rs) {
            $rsModules = $rs->modulesSummary();
            $moduleNames = array_keys($rsModules);
            foreach($moduleNames as $mn) { // mn for Module Name
                if (array_key_exists($mn, $usedModules)){
                    if ($usedModules[$mn] < $rsModules[$mn])
                        $usedModules[$mn] < $rsModules[$mn];
                }
                else {
                    $usedModules[$mn] = $rsModules[$mn];
                }
            }
        }

        $this->game = [
            'status' => $game->status,
            'id' => $game->id,
            'id_board' => $game->id_board,
            'options' => $game->getOptionsAsArray(),
            'modules' => $usedModules
        ];
        $this->boardId = 1;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("board.$this->boardId");
    }
}
