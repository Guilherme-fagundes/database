<?php
require __DIR__ . './../vendor/autoload.php';
require __DIR__.'./../app/config.php';

$read = new \database\Read();


$read->find('adm_user', 'WHERE adm_user_id != :id', "id=1");


var_dump($read->getResult());


