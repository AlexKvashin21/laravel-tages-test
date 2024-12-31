## Установка

1. Скопировать .env.example 

2. `docker-compose up nginx -d`

3. `docker-compose run --rm composer install`

4. `docker-compose run --rm artisan migrate --seed`

5. `docker-compose run --rm npm install`

6. `docker-compose run --rm npm run build`
