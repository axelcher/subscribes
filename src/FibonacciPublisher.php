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
        foreach ($this->fibonacciGenerator($this->getIteration()) as $value) {
            $msg = new AMQPMessage($value);
            $this->getChanel()->basic_publish($msg, '', self::$chanel);
            usleep($this->getTimeout());
        }
    }

    private function fibonacciGenerator($n)
    {
        $fib = [];
        for($i = 0; $i < $n; $i++) {
            if ($i < 2) {
                $number = $i;
            } else {
                $number = bcadd($fib[$i - 1], $fib[$i - 2]);
            }

            $fib[] = $number;
            yield $number;
        }
    }
}