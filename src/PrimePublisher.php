<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class PrimePublisher extends AbstractSubscribePublisher
{
    protected static $chanel = 'queue.chanel.prime';

    public function execute(): void
    {
        $msg = new AMQPMessage('prime '.rand(1, 1000));
        $this->getChanel()->basic_publish($msg, '', self::$chanel);
    }
}