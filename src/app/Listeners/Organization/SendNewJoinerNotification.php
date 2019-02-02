<?php

namespace App\Listeners\Organization;


use App\Events\Organization\UserJoined;
use App\Notifications\Organization\YouWereAddedToOrganization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewJoinerNotification implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param UserJoined $event
     * @return void
     */
    public function handle(UserJoined $event)
    {
        Notification::send($event->organizationUser->user, new YouWereAddedToOrganization($event->organizationUser));
    }
}