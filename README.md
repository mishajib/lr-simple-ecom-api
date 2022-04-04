# Installation Process

- First clone the repository.
- Run `composer update` or `composer install` to install dependencies.
- Copy the `.env.example` file to `.env` and edit it to your needs.
- Run `php artisan key:generate` to generate a new key.
- Run `php artisan migrate --seed` to migrate the database.
- Run `php artisan passport:install` to generate access tokens.
- Run `php artisan serve` to run the application.
