<p align="center">
	<img src="https://i.imgur.com/2LUR2yy.png" width="400">
</p>

# Veus Commerce API

- [Requirements](#requirements)
- [Setup Instructions](#instructions)
- [Usage](#usage)

<a name='requirements'></a>
## Requirements
- PHP 7+
- Composer
- Laravel

<a name='instructions'></a>
## Setup Instructions

**Clone this repository in a folder of your choice:**
```
git clone https://github.com/FabioNazario/veus-commerce.git
```

**Create databases  (MySQL)**
```
$ mysql -u root -e "create database veus_commerce collate utf8mb4_unicode_ci"
$ mysql -u root -e "create database veus_commerce_testing collate utf8mb4_unicode_ci"
```
>Note: 
>Run all commands  bellow  inside project folder.

**Make a copy of ".env.example" and rename to ".env"**
```
cp .env.example .env 
```

**Edit  database credentials in ".env" file**
```
DB_DATABASE=veus_commerce
DB_USERNAME=<your_db_username>
DB_PASSWORD=<your_db_password>
```

**Download/update project dependencies**
```
$ composer update no-scripts
```
**Generate APP_KEY and JWT_SECRET to ".env" file:**
```
$ php artisan key:generate
$ php artisan jwt:secret
```
**Run migrations:**
```
$ php artisan migrate --seed
```

**Start server:**
```
$ php artisan serve
```

<a name='usage'></a>
## Usage

**Available Routes to consume:**
```
+--------+-----------+---------------------------+------------------+----------------------------------------------------------+--------------+
| Domain | Method    | URI                       | Name             | Action                                                   | Middleware   |
+--------+-----------+---------------------------+------------------+----------------------------------------------------------+--------------+
|        | POST      | api/v1/login              | login            | App\Http\Controllers\Api\Auth\LoginJwtController@login   | api          |
|        | GET|HEAD  | api/v1/logout             | logout           | App\Http\Controllers\Api\Auth\LoginJwtController@logout  | api          |
|        | GET|HEAD  | api/v1/products           | products.index   | App\Http\Controllers\Api\ProductController@index         | api,jwt.auth |
|        | POST      | api/v1/products           | products.store   | App\Http\Controllers\Api\ProductController@store         | api,jwt.auth |
|        | GET|HEAD  | api/v1/products/create    | products.create  | App\Http\Controllers\Api\ProductController@create        | api,jwt.auth |
|        | GET|HEAD  | api/v1/products/{product} | products.show    | App\Http\Controllers\Api\ProductController@show          | api,jwt.auth |
|        | PUT|PATCH | api/v1/products/{product} | products.update  | App\Http\Controllers\Api\ProductController@update        | api,jwt.auth |
|        | DELETE    | api/v1/products/{product} | products.destroy | App\Http\Controllers\Api\ProductController@destroy       | api,jwt.auth |
|        | GET|HEAD  | api/v1/refresh            | refresh          | App\Http\Controllers\Api\Auth\LoginJwtController@refresh | api          |
+--------+-----------+---------------------------+------------------+----------------------------------------------------------+--------------+
```

>Note: To retrieve the list above, use this command: ```$ php artisan route:list```


**Login  Credentials**
```
user:user@email.com
pass:password
```

**Run Tests**
```
$ vendor/bin/phpunit --testdox
```
