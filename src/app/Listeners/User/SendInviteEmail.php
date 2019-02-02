<?php

namespace App\Listeners\User;

use App\Events\User\UserInvited;
use App\Notifications\User\NewUserInvited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * Send invited user an e-mail with registration link
 *
 * @package App\Listeners\User
 */
class SendInviteEmail implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param UserInvited $event
     * @return void
     */
    public function handle(UserInvited $event)
    {

        Log::info('Generated a new invitation code', [
            'email' => sha1($event->invite->for),
            'invitation_id' => $event->invite->id,
            'inviter_id'=> $event->inviter->id
        ]);

        $notification =new NewUserInvited($event->invite->code, $event->inviter->name);
        Notification::send($event->invite, $notification);
    }
}
