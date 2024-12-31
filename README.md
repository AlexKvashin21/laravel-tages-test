## Документация

### Backend (Laravel 11 + Inertia.js + Mysql + Redis + Pusher Websockets)

### Frontend (Vue 3 + Tailwind + Inertia.js + Axios)

## Сборка

Скопировать .env.example в .env

```bash
docker-compose up nginx -d
```

```bash
docker-compose run --rm composer install
```

```bash
docker-compose run --rm artisan migrate --seed
```

```bash
docker-compose run --rm npm install
```

```bash
docker-compose run --rm npm run build
```

Перейти по адресу http://localhost:8000/

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

[//]: # (smaller size)
<p align="center"><a href="https://vuejs.org" target="_blank"><img src="https://vuejs.org/images/logo.png"  width="120" height="120" alt="vue.js"></a></p>
