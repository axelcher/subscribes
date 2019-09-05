<?php


namespace App;


use PhpAmqpLib\Message\AMQPMessage;

class PrimePublisher extends AbstractSubscribePublisher
{
    protected static $chanel = 'queue.chanel.prime';

    public function execute(): void
    {
        $number = 2;
        $maxIteration = 0;
        while ($maxIteration < $this->getIteration()) {
            if ($this->isPrime($number)) {
                $msg = new AMQPMessage($number);
                $this->getChanel()->basic_publish($msg, '', self::$chanel);
                $maxIteration++;
            }
            $number++;
            usleep($this->getTimeout());
        }
    }

    private function isPrime($number): bool
    {
        if ($number == 2) {
            return true;
        }

        if ($number % 2 == 0) {
            return false;
        }

        $i = 3;
        $max_factor = (int)sqrt($number);
        while ($i <= $max_factor) {
            if ($number % $i == 0) {
                return false;
            }
            $i += 2;
        }

        return true;
    }
}