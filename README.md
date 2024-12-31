## Установка

\`\`\`bash
docker-compose up nginx -d
\`\`\`

скопировать .env.example

\`\`\`bash
docker-compose run --rm composer install
\`\`\`

\`\`\`bash
docker-compose run --rm artisan migrate --seed
\`\`\`

\`\`\`bash
docker-compose run --rm npm install
\`\`\`

\`\`\`bash
docker-compose run --rm npm run build
\`\`\`

## Готово
