<?php

require dirname(__FILE__, 3) . "/vendor/autoload.php";


echo 'Fetch users...';
$users = include dirname(__FILE__) . "/utils/getUsers.php";


// output
echo '' . PHP_EOL;
echo 'Users:' . PHP_EOL;

foreach ($users as $user) {
    echo $user->username . PHP_EOL;
}

echo PHP_EOL;
