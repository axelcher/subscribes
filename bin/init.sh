composer install
php ./bin/console.php PrepareDB
php ./bin/console.php FibonacciConsumer &
php ./bin/console.php PrimeConsumer &