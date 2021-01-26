<?php

require __DIR__.'/app/config.php';
require __DIR__."/vendor/autoload.php";

$users = new \App\Models\UserModel();
$users->findAny('id >= :id AND idade >= :idade', [
    'id' => 45,
    'idade' => 10
]);

var_dump($users);