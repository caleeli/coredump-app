## Setup

```
composer create-project --prefer-dist --stability dev coredump/app project
cd project
```

Configure the database:
If use sqlite set the fullpath for DB_DATABASE
```
vi .env
php artisan migrate --seed
```

Setup oauth
```
php artisan passport:install
```

Prepare frontend
```
npm install
npm run dev
```

Start the server:
```
php artisan serve
```
