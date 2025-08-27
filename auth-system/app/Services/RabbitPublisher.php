<?php
namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitPublisher
{
    protected $channel;
    protected $conn;

    public function __construct()
    {
        $this->conn = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASS', 'guest')
        );

        $this->channel = $this->conn->channel();
        $this->channel->exchange_declare('portfolio.events', 'topic', false, true, false);
    }

    public function publish(string $routingKey, array $payload)
    {
        // dd($routingKey, $payload);
        $msg = new AMQPMessage(json_encode($payload), [
            'content_type' => 'application/json',
            'delivery_mode'=> 2
        ]);
        // dd($msg);
        // dd($this->channel);
        //
        $this->channel->basic_publish($msg, 'portfolio.events', $routingKey);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->conn->close();
    }
}
