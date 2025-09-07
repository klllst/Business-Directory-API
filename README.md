1. cp .env.example .env
2. docker compose up -d --build
3. docker compose exec php-fpm bash
4. composer install
5. php artisan key:generate
6. php artisan optimize
7. php artisan migrate --seed
8. php artisan l5-swagger:generate
