@component('mail::message')
# A user has joined your event!

@component('mail::panel')
**Event Details:**  
{{ $event->title }}

Visit your events page to see and manage all current events.
@endcomponent

Thanks,<br>
{{ $_ENV['API_NAME'] }} Team
@endcomponent