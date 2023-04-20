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