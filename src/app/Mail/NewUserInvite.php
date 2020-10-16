<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected User $inviter;

    /**
     * Create a new message instance.
     *
     * @param User $inviter
     */
    public function __construct(User $inviter)
    {
        $this->inviter = $inviter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.invited', ['inviterName' => $this->inviter->name])
            ->subject(__('notification.user.invitation_mail.subject'));
    }
}
