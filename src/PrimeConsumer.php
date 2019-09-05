<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class PrimeConsumer extends AbstractSubscribeConsumer
{
    protected static $chanel = 'queue.chanel.prime';
    protected static $counterName = 'count_prime';

    public function execute(): void
    {
        $this->startListener();
    }
}