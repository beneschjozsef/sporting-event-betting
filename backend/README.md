# Sporting Event Betting Backend

This repository contains the backend services for a sporting event betting application. Below are the instructions to get started and manage the application.

## Initial Setup

Before you start using the application, you need to set up the necessary databases. Use the following commands to start the backend and create the necessary tables.

### Start Backend

To launch the backend services, run:

```bash
cd backend
docker-compose up --build
```

### Create Tables

If you don't already have the database tables created, use this command:

```bash
docker-compose run backend php artisan doctrine:migrations:migrate
```

### Additional Information

The following commands are not necessary for initial setup but can be useful for managing the application.

```bash
# Clear Doctrine Cache
# To clear the Doctrine metadata, query, and result caches, use the following commands:
php artisan doctrine:clear:metadata:cache
php artisan doctrine:clear:query:cache
php artisan doctrine:clear:result:cache

#migrate tables locally
php artisan make:migration:migrate

# Generate Autoload
composer dump-autoload

#Load Test Data
php artisan db:seed --class=DatabaseSeeder

#Start Locally
php -S localhost:8000 -t public
```
