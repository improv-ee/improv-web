<?php

namespace App\Orm;

use Illuminate\Notifications\Notifiable;

class Invite extends \Clarkeash\Doorman\Models\Invite
{
    use Notifiable;

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->for;
    }
}