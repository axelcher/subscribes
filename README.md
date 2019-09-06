# subscribes

sudo docker-compose exec php bash

sh ./bin/init.sh


php ./bin/console.php FibonacciPublisher 4 600
php ./bin/console.php PrimePublisher 5 600

php ./bin/console.php FibonacciConsumer
php ./bin/console.php PrimeConsumer