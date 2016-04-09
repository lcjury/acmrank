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

/*
 * User with most accepted first, if two users have
 * the same amount of accepted, the user with less
 * submissions is higher on the ranking
 *
function accepted_cmp($user, $other_user)
{
    if($user['accepted'] == $other_user['accepted'])
        if($user['submissions'] == $other_user['submissions'])
            return 0;
        else
            return $user['submissions'] > $other_user['submissions'] ? 1 : -1;

    return $user['accepted'] > $other_user['accepted'] ? -1 : 1;
}*/
$students = Student::all();
#$students->sort('function');
#$users_id = [$hunter->getIdFromUsername("lcjury"), 98807];

foreach($students as $student)
  $users[] = $hunter->userRanklist($student->uva_id,0,0)[0];

uasort($users, 'Student::accepted_cmp');

$view = $blade->view()->make('index', ['users' => $users]);

echo $view->render();
?>
