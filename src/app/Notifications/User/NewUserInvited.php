<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserInvited extends Notification
{
    use Queueable;
    /**
     * @var string
     */
    private $invitationCode;
    /**
     * @var string
     */
    private $inviterName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $invitationCode, string $inviterName)
    {
        $this->invitationCode = $invitationCode;
        $this->inviterName = $inviterName;
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
        return (new MailMessage)
            ->subject(__('notification.user.invitation_mail.subject'))
            ->line(__('notification.user.invitation_mail.you_have_been_invited_to_join', ['name' => $this->inviterName]))
            ->action(__('notification.user.invitation_mail.action_button'), route('register', ['code' => $this->invitationCode]))
            ->line(__('notification.user.invitation_mail.app_intro'));
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
