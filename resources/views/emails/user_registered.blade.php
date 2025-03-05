@component('mail::message')
# Welcome, {{ $user->name }}!

@component('mail::panel')
Thank you for joining us at {{$_ENV['API_NAME']}}. We are excited to have you on board.

If you have any questions, feel free to reach out to us.
@endcomponent

Thanks,<br>
{{ $_ENV['API_NAME'] }} Team
@endcomponent