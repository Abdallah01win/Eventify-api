<!DOCTYPE html>
<html>

<head>
    <title>Event Updated</title>
</head>

<body>
    <h1>The event you joined has been updated</h1>
    <p>Event: {{ $event->title }}</p>
    <p>Description: {{ $event->description }}</p>
    <p>Location: {{ $event->location }}</p>
    <p>Start Date: {{ $event->start_date }}</p>
    <p>End Date: {{ $event->end_date }}</p>
    <p>Thank you for using our application!</p>
</body>

</html>