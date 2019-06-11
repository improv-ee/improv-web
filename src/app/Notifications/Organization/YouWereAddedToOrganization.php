<?php

namespace App\Notifications\Organization;

use App\Orm\OrganizationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class YouWereAddedToOrganization extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var OrganizationUser
     */
    public $organizationUser;

    /**
     * Create a new notification instance.
     *
     * @param OrganizationUser $newMember
     */
    public function __construct(OrganizationUser $newMember)
    {
        $this->organizationUser = $newMember;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $org = $this->organizationUser->organization;

        return (new MailMessage)
            ->subject(__('notification.organization.new_member.subject'))
            ->greeting(__('notification.organization.new_member.greeting', ['name' => $this->organizationUser->user->name]))
            ->line(__('notification.organization.new_member.you_joined', ['org' => $org->name]))
            ->action(__('notification.organization.new_member.view_org'), url('/admin/#/organizations/' . $org->uid));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
