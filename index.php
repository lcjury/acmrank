<?php
use Hunter\Hunter;
use Philo\Blade\Blade;

require "vendor/autoload.php";
require "config/database.php";
require "init.php";
$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new Blade($views, $cache);
$hunter = new Hunter();
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$students = Student::all()->sort('Student::accepted_cmp');

#foreach($students as $student)
#  $users[] = $hunter->userRanklist($student->uva_id,0,0)[0];

$view = $blade->view()->make('index', ['users' => $students]);

echo $view->render();
?>
