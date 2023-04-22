# Пример реализации архитектуры

## Зависимости
Должен быть установлен [docker](https://www.docker.com/), [docker-compose](https://docs.docker.com/compose/). 

## Сеть
Необходимо создать внешнюю сеть `docker network create docker_default`.

## Запуск проекта с помощью docker-compose
* `docker-compose up --build -d` - запустить приложение
* `docker down --remove-orphans` - остановить приложение

## Консольные команды
* `composer cs-fix` - исправление стиля кода, согласно правилам cs-fixer
* `bin/console app:set-price alias2 1234` - установка цены _1234_ для товара с алиасом _alias2_

## Источники
* [PHP DDD Example](https://github.com/CodelyTV/php-ddd-example) от CodelyTV - взят за основу и упрощен
* [CQRS with Symfony Messenger](https://dev.to/adgaray/cqrs-with-symfony-messenger-2h3g)
* [Symfony Messenger](https://symfony.com/doc/current/messenger.html)
  
{"id": "11c6f729-6f84-41e9-aef3-5acae67d26d5","alias": "alias","name": "product number one","price": {"value": 123,"currency": "USD"}}