
Запуск контейнера

    sudo docker-compose up --build

Перейти в консоль php

    sudo docker-compose exec php bash

Инициализация приложения

    sh ./bin/init.sh

Запуск с консоли генераторов подписчиков

    php ./bin/console.php FibonacciPublisher <количество> <время задержки>

    php ./bin/console.php PrimePublisher <количество> <время задержки>
