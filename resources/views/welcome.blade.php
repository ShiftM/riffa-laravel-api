<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <style>
        input, button { padding: 10px; }
    </style>
</head>
<body>
<h1>Web Socket Test</h1>
<input type="text" id="message" />
<button onclick="transmitMessage()">Send</button>

<script type="text/javascript">
// Create a new WebSocket.
var socket  = new WebSocket('ws://localhost:8080/api/v1/test-socket');

// Define the 
var message = document.getElementById('message');

function transmitMessage() {
    socket.send( message.value );
}

socket.onmessage = function(e) {
    alert( e.data );
}
</script>
</body>
</html>