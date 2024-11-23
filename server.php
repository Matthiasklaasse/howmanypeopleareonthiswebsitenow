<?php
require '../vendor/autoload.php'; 

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;

class MyWebSocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; 
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection: ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Message from {$from->resourceId}: $msg\n";
        if($msg == 'count'){
            $from->send(count($this->clients));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}


$app = new App('localhost', 8234);  // Set WebSocket server to run on localhost:8080
$app->route('/chat', new MyWebSocketServer, ['*']);
$app->run();
