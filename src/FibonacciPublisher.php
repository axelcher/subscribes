<?php
namespace App;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class FibonacciGenerator
 * @package App
 */
class FibonacciPublisher extends AbstractSubscribePublisher
{
    protected static $chanel = 'queue.chanel.fibonacci';

    public function execute(): void
    {
        for ($counter = 0; $counter < $this->getIteration(); $counter++) {
            $msg = new AMQPMessage($this->fibonacci($counter));
            $this->getChanel()->basic_publish($msg, '', self::$chanel);
            usleep($this->getTimeout());
        }
    }

    private function fibonacci($number): int
    {
        if ($number == 0) {
            return 0;
        } else if ($number == 1) {
            return 1;
        } else {
            return ($this->fibonacci($number-1) + $this->fibonacci($number-2));
        }
    }
}