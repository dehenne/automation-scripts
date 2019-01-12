<?php

require dirname(__FILE__, 4) . '/vendor/autoload.php';

$limit = 100;

/**
 * Get all Makerlog users
 */

$Guzzle = new \GuzzleHttp\Client();
$Request = $Guzzle->request('GET', 'https://api.getmakerlog.com/users');
$users = json_decode($Request->getBody());

$maxUsers = $users->count;
$offset = 0;
$result = [];

while ($offset < $maxUsers) {
    $Request = $Guzzle->request('GET', 'https://api.getmakerlog.com/users', [
        'query' => [
            'limit' => $limit,
            'offset' => $offset
        ]
    ]);

    $users = json_decode($Request->getBody());
    $offset = $offset + $limit;

    // get twitter users from makerlog users
    foreach ($users->results as $user) {
        $result[] = $user;
    }
}

return $result;
