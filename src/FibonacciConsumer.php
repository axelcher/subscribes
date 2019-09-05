<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class FibonacciConsumer extends AbstractSubscribeConsumer
{
    protected static $chanel = 'queue.chanel.fibonacci';

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


//        $db->beginTransaction();
//        $db->exec('LOCK TABLES t1, t2, ...');
//# do something with tables
//        $db->commit();
//        $db->exec('UNLOCK TABLES');
    }
}