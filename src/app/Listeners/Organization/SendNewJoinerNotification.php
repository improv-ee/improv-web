<?php

namespace App\Listeners\Organization;


use App\Events\Organization\UserJoined;
use App\Notifications\Organization\NewMemberApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendNewJoinerNotification implements ShouldQueue
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
     * @param UserJoined $event
     * @return void
     */
    public function handle(UserJoined $event)
    {
        Notification::send($event->organizationUser->user, new NewMemberApplication($event->organizationUser));
    }
}