<?php

namespace App\Listeners\User;

use App\Events\User\UserInvited;
use App\Notifications\User\NewUserInvited;
use App\User;
use Clarkeash\Doorman\Facades\Doorman;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendInviteEmail implements ShouldQueue
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
     * @param  object $event
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
