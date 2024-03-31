## Tweaks Authentication service

```
composer update
php artisan migrate
php artisan db:seed
```

```
php artisan migrate:fresh
```
/register route is blocked in app/Http/Middleware/BlockRoute.php, app/Http/Kernel.php and web.php
