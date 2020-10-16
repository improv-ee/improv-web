@component('mail::message')

{{ __('notification.greeting') }}

{{ __('notification.user.invitation_mail.you_have_been_invited_to_join', ['name' => $inviterName]) }}

{{ __('notification.user.invitation_mail.app_intro') }}

@component('mail::button', ['url' => route('register')])
{{ __('notification.user.invitation_mail.action_button') }}
@endcomponent


@endcomponent
