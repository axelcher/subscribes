<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class PrimeConsumer extends AbstractSubscribeConsumer
{
    protected static $chanel = 'queue.chanel.prime';

    public function execute(): void
    {
        $this->getChanel()->basic_consume(self::$chanel, '', false, true, false, false, [$this, 'registerSubscriber']);

        while ($this->getChanel()->is_consuming()) {
            $this->getChanel()->wait();
        }
    }

    public function registerSubscriber(AMQPMessage $msg): void
    {
        $message = $msg->body;
        var_dump($message);
    }
}