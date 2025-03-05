@component('mail::message')
# Event Update: {{ $event->title }}

An event you're participating in has been modified. Here are the updated details:

@component('mail::panel')
** Location**<br>
{{ $event->location }}

** Schedule**<br>
Starts: {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y \a\t g:i A') }}<br>
Ends: {{ \Carbon\Carbon::parse($event->end_date)->format('l, F j, Y \a\t g:i A') }}

** Description**<br>
Description: {{ $event->description }}
@endcomponent

If these changes don't work for you, you can always update your attendance status from the event page.

Thanks,<br>
{{ $_ENV['API_NAME'] }} Team
@endcomponent