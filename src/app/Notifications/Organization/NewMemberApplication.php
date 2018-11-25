<?php

namespace App\Notifications\Organization;

use App\Orm\OrganizationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewMemberApplication extends Notification implements ShouldQueue
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
            ->greeting(__('notification.organization.new_member_application.greeting', ['org' => $org->name]))
            ->line(__('notification.organization.new_member_application.name_wants_to_join', ['name' => $this->organizationUser->user->name]))
            ->action(__('notification.organization.new_member_application.manage_members'), url('/admin/#/organizations/' . $org->slug));
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
