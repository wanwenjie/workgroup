<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('17ed5c6268b322851fbc', {
      cluster: 'ap1',
      encrypted: true
    });


    var channel = pusher.subscribe('chat-room.1');
    channel.bind('ChatMessageWasReceived', function(data) {
      alert(data.message);
    });
  </script>
</head>

