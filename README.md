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