<?php

namespace App\Listeners;

use App\Events\GetUserInteraction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterInteraction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GetUserInteraction  $event
     * @return void
     */
    public function handle(GetUserInteraction $event)
    {
        //
    }
}
