<?php
require "vendor/autoload.php";
require "config/database.php";
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('students', function($table)
    {
        $table->increments('id');
        $table->integer('uva_id')->unsigned();
        $table->string('name');
        $table->integer('accepted')->unsigned()->default(0);
        $table->integer('submissions')->unsigned()->default(0);
        $table->integer('last_submission')->unsigned()->default(0);
    });
Capsule::schema()->create('solveds', function($table)
    {
        $table->increments('id');
        $table->integer('problem_id')->unsigned();
        $table->integer('timestamp')->unsigned();
        $table->integer('student_id')->unsigned();

        $table->foreign('student_id')
            ->references('id')->on('students');
    });

Capsule::schema()->create('options', function($table)
    {
        $table->string('name');
        $table->integer('value');
        $table->primary('name');
    });
Student::create(['uva_id' => 99441, 'name' => 'luis jury']);
Option::create(['name' => 'last_update', 'value' => 0]);

?>
