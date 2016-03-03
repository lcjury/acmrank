<?php
use Hunter\Hunter;
use Philo\Blade\Blade;

require "vendor/autoload.php";
$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$hunter = new Hunter();

/*
 * User with most accepted first, if two users have
 * the same amount of accepted, the user with less
 * submissions is higher on the ranking
 */
function accepted_cmp($user, $other_user)
{
    if($user['accepted'] == $other_user['accepted'])
        if($user['submissions'] == $other_user['submissions'])
            return 0;
        else
            return $user['submissions'] > $other_user['submissions'] ? 1 : -1;

    return $user['accepted'] > $other_user['accepted'] ? -1 : 1;
}

$users_id = [$hunter->getIdFromUsername("lcjury"), 98807];

foreach($users_id as $user_id)
  $users[] = $hunter->userRanklist($user_id,0,0)[0];

uasort($users, 'accepted_cmp');

$blade = new Blade($views, $cache);
$view = $blade->view()->make('index', ['users' => $users]);

echo $view->render();
?>
