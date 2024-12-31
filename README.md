## Документация

Backend (Laravel 11 + Inertia.js + Mysql + Redis + Pusher Websockets)

Frontend (Vue 3 + Tailwind + Inertia.js + Axios)

## Сборка

1. Скопировать .env.example 

2. `docker-compose up nginx -d`

3. `docker-compose run --rm composer install`

4. `docker-compose run --rm artisan migrate --seed`

5. `docker-compose run --rm npm install`

6. `docker-compose run --rm npm run build`

7. Перейти по адресу http://localhost:8000/
