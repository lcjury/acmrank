<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    #   'driver' => 'mysql', 'database', 'username', 'password'
    'driver' => 'sqlite',
    'database' => __DIR__.'/../database.sqlite'
    ]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

?>
