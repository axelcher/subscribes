<?php


namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class AbstractSubscribeConsumer implements CommandInterface
{
    /** @var array */
    private $config;

    /** @var AMQPChannel */
    private $chanel;

    /** @var  AMQPStreamConnection */
    private $connection;

    /** @var \PDO */
    private $db;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->connection = new AMQPStreamConnection(
            $this->config['amqpHost'],
            $this->config['amqpPort'],
            $this->config['amqpUser'],
            $this->config['amqpPassword']
        );
        $this->chanel = $this->connection->channel();
        $this->getChanel()->queue_declare(static::$chanel, false, false, false, false);
        $this->db = new \PDO("mysql:host=mysql;dbname=" . $this->config['dbName'], $this->config['dbUser'], $this->config['dbPassword']);
        $this->db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }

    abstract public function execute(): void;

    protected function getChanel(): AMQPChannel
    {
        return $this->chanel;
    }

    public function __destruct()
    {
        $this->chanel->close();
        $this->connection->close();
    }

    public function getDB(): \PDO
    {
        return $this->db;
    }
}