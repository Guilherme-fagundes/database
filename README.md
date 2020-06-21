
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

or

```bash
"require": {
    coffeebreaks/database:*
}
```

####Config

<p>Connect with PDO</p>

```php
define('DB', [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => '',
    'driver' => 'mysql' //default = mysql
]);
```