<?php


namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class AbstractNumberGenerator
 * @package App
 */
abstract class AbstractSubscribePublisher implements CommandInterface
{
    /** @var int */
    private $iteration;

    /** @var int */
    private $timeout;

    /** @var array */
    private $config;

    /** @var AMQPChannel */
    private $chanel;

    /** @var  AMQPStreamConnection */
    private $connection;

    public function __construct(array $config, int $iteration, int $timeout)
    {
        $this->config = $config;
        $this->iteration = $iteration;
        $this->timeout = $timeout;
        $this->connection = new AMQPStreamConnection(
            $this->config['amqpHost'],
            $this->config['amqpPort'],
            $this->config['amqpUser'],
            $this->config['amqpPassword']
        );
        $this->chanel = $this->connection->channel();
        $this->getChanel()->queue_declare(static::$chanel, false, false, false, false);
    }

    abstract public function execute(): void;

    protected function getIteration(): int
    {
        return $this->iteration;
    }

    protected function getTimeout(): int
    {
        return $this->timeout;
    }

    protected function getChanel(): AMQPChannel
    {
        return $this->chanel;
    }

    public function __destruct()
    {
        $this->chanel->close();
        $this->connection->close();
    }
}