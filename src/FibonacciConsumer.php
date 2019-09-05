<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class FibonacciConsumer extends AbstractSubscribeConsumer
{
    protected static $chanel = 'queue.chanel.fibonacci';
    protected static $counterName = 'count_fib';

    public function execute(): void
    {
        $this->startListener();
    }
}