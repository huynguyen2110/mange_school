# go to project
# install app's dependencies
$ composer install

# install app's dependencies
$ install node v14x
$ install npm v6x

$ cp env.example .env

# edit connect database
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=manage_school
DB_USERNAME=root
DB_PASSWORD=root

### Next step

``` bash
# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate:refresh --seed

# generate mixing
$ npm run dev or npm run watch

# and repeat generate mixing
$ npm run dev

# generate interface and repository run command
$ php artisan make:repository name

#generate model from database
$ php artisan krlove:generate:model User --table-name=user

#generate enum
$ php artisan make:enum UserType

#clear cache
$ php artisan cache:clear

# install php cs fixer
$ create folder/tools/php-cs-fixer
$ composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
# refactor code before commit
$ tools/php-cs-fixer/vendor/bin/php-cs-fixer fix folder_code
