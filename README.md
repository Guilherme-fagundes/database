
[![Source Code](http://img.shields.io/badge/source-coffeebreaks/database-blue.svg?style=flat-square)](https://github.com/Guilherme-fagundes/database)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/coffeebreaks/database.svg?style=flat-square)](https://packagist.org/packages/coffeebreaks/database)
[![Latest Stable Version](https://poser.pugx.org/coffeebreaks/database/v)](//packagist.org/packages/coffeebreaks/database)
[![License](https://poser.pugx.org/coffeebreaks/database/license)](//packagist.org/packages/coffeebreaks/database)
[![Total Downloads](https://poser.pugx.org/coffeebreaks/database/downloads)](//packagist.org/packages/coffeebreaks/database)
[![Build](https://img.shields.io/scrutinizer/build/g/Guilherme-fagundes/database.svg?style=flat-square)](https://scrutinizer-ci.com/g/Guilherme-fagundes/database)
[![Quality Score](https://img.shields.io/scrutinizer/g/Guilherme-fagundes/database.svg?style=flat-square)](https://scrutinizer-ci.com/g/Guilherme-fagundes/database)


##### COFFEBREAKS/DATABASE

<p>
This component connects, registers, reads, edits and deletes records in the database.</p>

##### Intalation

```bash
composer require coffeebreaks/database
```


#### Config

<p>Connect with PDO</p>

```php
define('DB', [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'dbdebug',
    'port' => 3306,
    'driver' => 'mysql', //default = mysql
    'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]
]);
```

### Creating Model
<p>In the folder <b>app/Models</b> create the class <b>Users</b></p>

```php
<?php


namespace App\Models;


use Database\Database;

class Users extends Database
{
protected $table = "users";
}
```

### Creating user

```php
use App\Models\Users;

$user = new Users();

$user->name = "Guilherme";
$user->age = 26;

$user->save();


var_dump($user);
```

### Update user

```php
$user = new Users();
$user->id = 1;
$user->name = "Guilherme K.";
$user->age = 26;

$user->save();


var_dump($user);
```

### List all datas

```php
$user = new Users();

var_dump($user->all()->getGet());
```

### FindById

```php
$user = new Users();
$user->findById(1);


var_dump($user->getGet());
```

### FindByEmail

```php
$user = new Users();
$user->findByEmail("email@email.com");


var_dump($user->getGet());
```