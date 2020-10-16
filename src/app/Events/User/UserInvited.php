<?php

namespace App\Events\User;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Emitted when an user sends an invitation code to join the platform to an e-mail
 *
 * @package App\Events\User
 */
class UserInvited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The sender of the invitation
     *
     * @var User
     */
    public User $inviter;

    /**
     * @var string email address that was invited
     */
    public string $invited_email;

    /**
     * Create a new event instance.
     *
     * @param string $invited_email
     * @param User $inviter
     */
    public function __construct(User $inviter, string $invited_email)
    {
        $this->inviter = $inviter;
        $this->invited_email = $invited_email;
    }
}
