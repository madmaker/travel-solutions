# Тестовое Travel Solutions

## Структура
- /doc/ - документация
- /dockerfiles/ - файлы контейнеров
- /basic - Папка приложение YII2
- /basic/web - public папка. В нее смотрит nginx
- /.env - настройки окружения докер-сервиса

### Сборка docker-сервиса
- Сбилдить контейнеры `docker-compose build`
- Создать volume `docker volume create ts-mysql-data`
### Запуск docker-сервиса
`docker-compose up -d`

### Сборка composer
- Проваливаемся в контейнер backned `docker exec -it ts-backend bash`
- Проваливаемся в папку /var/www `cd /var/www`
- Ставим пакеты `composer install`