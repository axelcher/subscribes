
1.Запуск контейнера

    sudo docker-compose up --build

2.Перейти в консоль контейнера

    sudo docker-compose exec php bash

3.Инициализация приложения

    sh ./bin/init.sh

4.Запуск с консоли генераторов подписчиков

    php ./bin/console.php FibonacciPublisher <количество> <время задержки>

    php ./bin/console.php PrimePublisher <количество> <время задержки>
