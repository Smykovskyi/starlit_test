# Test for starlit group

## System Requirements
- Php > 8.1.x
- Pgsql >= 13
- Composer 2.x

Before you start, do not forget, to create local env file (.env.dev or .env.local) and populate all necessary env variable 
for the project to successfully start.

You can create a database by running
```php bin/console doctrine:database:create```.

After you need to run the migration
```php bin/console do:mi:mi```.

To use a dummy data.
To do that after all migrations you need to run in your console
```php bin/console do:fi:lo```.

Start your web server and go to the ```/admin``` route.

Use admin credentials that you can find in fixtures file.