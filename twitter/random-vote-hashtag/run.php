<?php

echo '

 _______       _ _   _             __      __   _       
|__   __|     (_) | | |            \ \    / /  | |      
   | |_      ___| |_| |_ ___ _ __   \ \  / /__ | |_ ___ 
   | \ \ /\ / / | __| __/ _ \ \'__|   \ \/ / _ \| __/ _ \
   | |\ V  V /| | |_| ||  __/ |       \  / (_) | ||  __/
   |_| \_/\_/ |_|\__|\__\___|_|        \/ \___/ \__\___|

by @de_henne

';

require "../../vendor/autoload.php";
include 'config.php';

try {
    $Twitter = new Twitter(
        $consumerKey,
        $consumerSecret,
        $accessToken,
        $accessTokenSecret
    );
} catch (Exception $Exception) {
    echo '### '.$Exception->getMessage().PHP_EOL;
    exit(0);
}

// search by hashtag
try {
    $result = $Twitter->request('search/tweets', 'GET', [
        'q' => implode(' ', $hashtags)
    ]);
} catch (Exception $Exception) {
    echo $Exception->getMessage().PHP_EOL;
    exit;
}

// generate var folder
$mainFolder = dirname(dirname(dirname(__FILE__)));
$varFolder  = $mainFolder.'/var';
$cacheFile  = $varFolder.'/random-vote-hashtag';

if (!is_dir($varFolder)) {
    mkdir($varFolder);
}

if (!file_exists($cacheFile)) {
    file_put_contents($cacheFile, '');
}

$cache = explode("\n", file_get_contents($cacheFile));
$check = array_flip($cache);

foreach ($result->statuses as $Tweet) {
    if (isset($check[$tweet->id])) {
        continue;
    }

    // vote
    echo $tweet->id.PHP_EOL;
    echo $tweet->text.PHP_EOL;

    // randomly vote
    try {
        $vote = (bool)random_int(0, 1);

        if ($vote && !$Tweet->favorited) {
            $Twitter->request('favorites/create', 'POST', [
                'id' => $Tweet->id
            ]);

            echo '-> voted'.PHP_EOL;
        } else {
            echo '-> not voted'.PHP_EOL;
        }
    } catch (Exception $Exception) {
        echo '### '.$Exception->getMessage().PHP_EOL;
        continue;
    }

    echo PHP_EOL;

    $cache[] = $tweet->id;
}

file_put_contents($cacheFile, implode("\n", $cache));
