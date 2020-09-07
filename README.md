# Subway coding assigment
This project allows users to place orders for specific sandwiches. An admin user is able to manage the system and perform several tasks that regular users cannot do.

This project is build using Laravel 7.

## Installation
Before we can start, we need to clone the repository and install the required composer packages.
Execute the following commands on the CLI:

```
git clone https://github.com/kabsurd/subway-public subway
cd subway
composer install
cp .env.example .env
```

## Database
This project requires a database. This can be achieved in multiple ways. I build the project using a MySQL database but it is also possible to use a SQLite database.

### MySQL
Create a MySQL database(_utfmb4_) on you local or remote server. 
After creating the database, update the fields in the .env file so they match your settings.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
### SQLite
For using SQLite you need to create the database first. Make sure you are inside the project folder.
```
touch database/database.sqlite
```

After creating the database, we need to make some changes to the .env file:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
DB_FOREIGN_KEYS=true
```

## Database actions
To prepare the database, run the commands below. This will create the database tables and add some data.


```
php artisan migrate --seed
php artisan serve
```

## Usage

By running the `--seed` parameter, we created an admin user. This user can be used to create new users and meals.

**username:** admin@subsub.nl

**password:** Passw0rd

After logging in, the system should explain itself.
