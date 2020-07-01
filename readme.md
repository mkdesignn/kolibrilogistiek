## kolibrilogistiek Project

To install the dependencies you'll need to run
```
composer install
```

Note: For test purpose I have used sqlite database, You may need it in your local machine to get the test running

To run the migration, You can use
```
php artisan migrate
```

To have fake data, You can run 
```
php artisan db:seed
```

Note: You can specify the database configuration from the .env, 
I have used mysql for the database, But you can change the driver to any other driver (pgsql, sqlserver, ...).

**
You'll need to create the database before running the migration

I have used Vue.js for the FE
**

To run the server you can follow the following , open up the terminal and run the command 
```
php artisan serve
```
the server is running on port 8080

You can also run the tests by using 
```
vendor/bin/phpunit
```

**You can use admin user to access the dashboard, username: admin@kolibrilogistiek.com | password: secret
