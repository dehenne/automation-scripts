<?php

echo '
 _______       _ _   _            
|__   __|     (_) | | |           
   | |_      ___| |_| |_ ___ _ __ 
   | \ \ /\ / / | __| __/ _ \ \'__|
   | |\ V  V /| | |_| ||  __/ |   
   |_| \_/\_/ |_|\__|\__\___|_|   
                                  
Twitter random tweet by @de_henne

';

require "../../vendor/autoload.php";
include 'config.php';

// read the file with the quotes - tweets
$data = file_get_contents('quotes');
$data = explode("\n", $data);


// cleanup
$data = array_filter($data, function ($entry) {
    return !empty($entry);
});

$data = array_map(function ($entry) {
    return trim($entry);
}, $data);


if (!isset($hashTags)) {
    $hashTags = [];
}

$getQuote = function () {
};

/**
 * Helper to get a random quote - tweet
 *
 * @return string
 */

$getQuote = function () use ($data, $getQuote, $hashTags) {
    $entry = $data[array_rand($data)];

    $quote = $entry.' - ';
    $quote .= '#'.implode(' #', $hashTags);

    if (empty($entry)) {
        return $getQuote();
    }

    return $quote;
};

$quote = $getQuote();


/**
 * send to twitter
 */

try {
    $Twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    $status  = $Twitter->load(Twitter::ME);

    $Twitter->send($quote);
} catch (TwitterException $Exception) {
    echo PHP_EOL.'ERROR: '.$Exception->getMessage().PHP_EOL;
}

