## Dependencias
PHP 7.1^
composer
NodeJS
Redis
Extensiones PHP:
- openssl
- mbstring
- sqlite3

## Start a new project

You could change the name of the project: `my_project`
```
composer create-project --prefer-dist --stability dev coredump/app my_project
cd my_project
php artisan app:config
php artisan app:install
npm install
npm run dev
php artisan serve
```
## ionic

- Go to your new project: cd ./ionic
- Run ionic serve within the app directory to see your app in the browser
- Run ionic capacitor add to add a native iOS or Android project using Capacitor
- Generate your app icon and splash screens using cordova-res --skip-config --copy
- Explore the Ionic docs for components, tutorials, and more: https://ion.link/docs
- Building an enterprise app? Ionic has Enterprise Support and Features: https://ion.link/enterprise-edition

