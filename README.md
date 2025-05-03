## About Project

-   laravel 8.6
-   php 8.x
-   mysql

## Note

### First Install

-   `$ composer --ignore-platform-reqs`
-   create `.env` from `.env.example` (don't remove `.env.example`)
-   modify .env values (APP_KEY, APP_URL, DB, etc)
-   `$ php artisan config:cache` <-- every time you change the .env values
-   `$ php artisan migrate`
-   `$ php artisan db:seed`
-   `$ php artisan create:superadmin --username=your@email.com --password=yourpass` <-- create superadmin user
-   import excel
    -   tutor
    -   distribusi mapel
    -   rombel

### Misc

-   `$ php artisan key:generate` <-- generate APP_KEY
-   `$ php artisan queue:listen` <-- to run queue locally (for email or run job schedule)
-   `$ php artisan storage:link` <-- create a symbolic link from `public/storage` to `storage/app/public` (not work on sharehost server)
-   cron job `* * * * * /usr/local/bin/php /path/to/artisan schedule:run >> /dev/null 2>&1`
-   `$ php artisan make:import FeatureImport`
-   `$ php artisan make:export FeatureExport`
