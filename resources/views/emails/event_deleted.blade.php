@component('mail::message')
# Event Cancelled: {{ $event->title }}

@component('mail::panel')
We wanted to inform you that an event you were planning to attend has been cancelled by the organizer.

**Event Details**
{{ $event->title }}
Originally scheduled for: {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y \a\t g:i A') }}
@endcomponent

Looking for something else to attend? Check out our event listings to find similar events in your area.

Thanks,<br>
{{ $_ENV['API_NAME'] }} Team
@endcomponent