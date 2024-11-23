<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>howmanypeopleareonthiswebsitenow</title>
</head>

<body>
    <a id="counter"></a>
    <script>
        const counter = document.getElementById('counter');
        var conn = new WebSocket("ws://<?php echo $_SERVER['HTTP_HOST']; ?>:8234/chat");
        var messages = document.getElementById('messages');
        var messageInput = document.getElementById('message');

        conn.onopen = function() {
            console.log('WebSocket connection established');
        };

        conn.onmessage = function(e) {
            counter.innerHTML = e.data;
        };

        function countClients() {
            conn.send('count');
        }

        setInterval(() => {
            countClients();
        }, 1000);
    </script>
</body>

</html>