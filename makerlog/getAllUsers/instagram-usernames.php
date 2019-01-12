<?php

require dirname(__FILE__, 3) . "/vendor/autoload.php";


echo 'Fetch megamaker users ...';
$users = include dirname(__FILE__) . "/utils/getUsers.php";


// get instagram usernames
$users = array_map(function ($user) {
    return $user->instagram_handle;
}, $users);

// cleanup
$users = array_map(function ($user) {
    $user = explode('@', $user);
    $user = end($user);
    $user = trim($user);

    return $user;
}, $users);

$users = array_filter($users, function ($user) {
    return !empty($user);
});


// output
echo '' . PHP_EOL;
echo 'Users:' . PHP_EOL;

foreach ($users as $user) {
    echo $user . PHP_EOL;
}

echo PHP_EOL;
