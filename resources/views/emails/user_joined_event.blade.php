<!DOCTYPE html>
<html>

<head>
    <title>User Joined Event</title>
</head>

<body>
    <h1>A user has joined your event</h1>
    <p>Event: {{ $event->title }}</p>
    <p>User: {{ $user->name }} ({{ $user->email }})</p>
    <p>Thank you for using our application!</p>
</body>

</html>