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
} catch (\Exception $Exception) {
    echo '### '.$Exception->getMessage().PHP_EOL;
    exit(0);
}


foreach ($users as $user) {
    echo 'Look at '.$user.PHP_EOL;

    try {
        $status = $Twitter->request('statuses/user_timeline', 'GET', [
            'screen_name' => $user
        ]);
    } catch (\Exception $Exception) {
        echo '### '.$Exception->getMessage().PHP_EOL;
        continue;
    }

    foreach ($status as $Status) {
        if ($Status->favorited) {
            continue;
        }

        echo '- Vote '.$Status->id;

        try {
            $Twitter->request('favorites/create', 'POST', [
                'id' => $Status->id
            ]);
        } catch (\Exception $Exception) {
            echo '### '.$Exception->getMessage().PHP_EOL;
            continue;
        }

        echo PHP_EOL;
    }
}
