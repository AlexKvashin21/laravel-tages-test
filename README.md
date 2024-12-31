## Установка

1. `docker-compose up nginx -d`
2. Скопировать .env.example
3. `docker-compose run --rm composer install`
4. `docker-compose run --rm artisan migrate --seed`
5. `docker-compose run --rm npm install`
6. `docker-compose run --rm npm run build`

## Готово
