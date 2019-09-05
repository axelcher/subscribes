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
        $msg = new AMQPMessage(rand(1, 1000));
        $this->getChanel()->basic_publish($msg, '', self::$chanel);
    }





//    function fibonacci ($from, $to)
//    {
//        $a = 0;
//        $b = 1;
//        $tmp;
//        while( $to > 0 ) {
//            if( $from > 0 ){
//                $from--;
//            } else {
//                yield $a;
//            }
//            $tmp = $a + $b;
//            $a = $b;
//            $b = $tmp;
//            $to--;
//        }
//    }
//foreach( fibonacci(10, 20) as $fib ) {
//echo $fib." "; // prints "55 89 144 233 377 610 987 1597 2584 4181 "
//}
}