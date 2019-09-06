<?php


namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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

    public function startListener(): void
    {
        $this->getChanel()->basic_consume(static::$chanel, '', false, true, false, false, [$this, 'registerSubscriber']);

        while ($this->getChanel()->is_consuming()) {
            $this->getChanel()->wait();
        }
    }

    public function registerSubscriber(AMQPMessage $msg): void
    {
        $increment = $msg->body;
        $this->getDB()->exec('START TRANSACTION');

        $query = $this->getDB()->prepare("SELECT * FROM test LIMIT 1 FOR UPDATE");
        $query->execute();
        $row = $query->fetch();
        $data = [
            'sum' => bcadd($row['sum'],$increment),
            static::$counterName => (int)$row[static::$counterName] + 1,
            'id' => (int)$row['id'],
        ];

        $sql = "UPDATE test SET sum=:sum, ". static::$counterName  ."=:". static::$counterName  ." WHERE id=:id";
        $this->getDB()->prepare($sql)->execute($data);
        $this->getDB()->exec('COMMIT');
    }
}