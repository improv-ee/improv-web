<?php

namespace App\Listeners\User;

use App\Events\User\UserInvited;
use App\Mail\NewUserInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        Log::info('Sending a new invite email', [
            'email' => sha1($event->invited_email),
            'inviter_id'=> $event->inviter->id
        ]);

        Mail::to($event->invited_email)->send(new NewUserInvite($event->inviter));
    }
}
