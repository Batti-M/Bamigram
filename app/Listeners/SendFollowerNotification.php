<?php

namespace App\Listeners;

use App\Events\FollowerGained;
use App\Mail\NewFollower;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFollowerNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FollowerGained $event)
    {
        Mail::to($event->followed->email)->send(new NewFollower($event->follower));
    }
}
