mysql indítása:
docker-compose up -d

php artisan make:migration create_products_table

cache törlése, autoload generálása:
php artisan doctrine:clear:metadata:cache
php artisan doctrine:clear:query:cache
php artisan doctrine:clear:result:cache
composer dump-autoload

minden migrálása: php artisan doctrine:migrations:migrate

ez létrehozza a migrációs szerkezetet amit szerkeszteni kellhet

tesztadatok betöltése: php artisan db:seed --class=ProductSeeder

autoload frissítése: composer dump-autoload


indítás: php -S localhost:8000 -t public
