<?php

namespace App\Events\User;

use App\Orm\Invite;
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
     * @var Invite
     */
    public $invite;

    /**
     * The sender of the invitation
     *
     * @var User
     */
    public $inviter;

    /**
     * Create a new event instance.
     *
     * @param Invite $invite
     * @param User $inviter
     */
    public function __construct(Invite $invite, User $inviter)
    {
        $this->invite = $invite;
        $this->inviter = $inviter;
    }
}
