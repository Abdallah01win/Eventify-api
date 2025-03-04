<!DOCTYPE html>
<html>

<head>
    <title>User Left Event</title>
</head>

<body>
    <h1>A user has left your event</h1>
    <p>Event: {{ $event->title }}</p>
    <p>User: {{ $user->name }} ({{ $user->email }})</p>
    <p>Thank you for using our application!</p>
</body>

</html>