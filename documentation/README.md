## Step By Step

-   1. Composer Installation `composer install`
-   2. Npm Installation ` yarn install`
-   3. Run Prod For Public Binding Js/Css `yarn prod`
-   4. To make key Gen : `copy .env.example to .env`
-   5. Run `php artisan key:generate`
-   6. Make sure Database Config and `php artisan cache:clear && php artisan config:cache`
-   7. Seeder `php artisan db: seed` or `php artisan migrate:refresh --seed`
