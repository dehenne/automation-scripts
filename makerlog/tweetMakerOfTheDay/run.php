<?php

echo '
  __  __          _  ________ _____  _      ____   _____ 
|  \/  |   /\   | |/ /  ____|  __ \| |    / __ \ / ____|
| \  / |  /  \  | \' /| |__  | |__) | |   | |  | | |  __ 
| |\/| | / /\ \ |  < |  __| |  _  /| |   | |  | | | |_ |
| |  | |/ ____ \| . \| |____| | \ \| |___| |__| | |__| |
|_|  |_/_/    \_\_|\_\______|_|  \_\______\____/ \_____|
                                                        

Send a tweet to the Maker of the Day of Makerlog by @de_henne

';

require dirname(__FILE__, 3)."/vendor/autoload.php";
include 'config.php';


$Makerlog = new \PCSG\Makerlog\Makerlog();
$Stats    = $Makerlog->getStats();

$MakerOfTheDay = $Stats->getStats()->maker_of_the_day;

if (empty($MakerOfTheDay->twitter_handle)) {
    echo 'User has no twitter handle';
    exit(1);
}

$twitterUsername = $MakerOfTheDay->twitter_handle;
$twitterUsername = trim($twitterUsername);
$twitterUsername = '@'.$twitterUsername;

echo "Send message to ".$MakerOfTheDay->twitter_handle;

/**
 * Start twitter
 */

try {
    $Twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
} catch (TwitterException $Exception) {
    echo PHP_EOL.'ERROR: '.$Exception->getMessage().PHP_EOL;
    exit(1);
}

// Check if user exists
try {
    $info = $Twitter->loadUserInfo($twitterUsername);
} catch (TwitterException $Exception) {
    echo PHP_EOL.'ERROR: '.$Exception->getMessage().PHP_EOL;
    exit(1);
}

/**
 * send to twitter
 */

$message = str_replace('[user]', $twitterUsername, $message);

try {
    $Twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    $status  = $Twitter->load(Twitter::ME);

    $Twitter->send($message);
} catch (TwitterException $Exception) {
    echo PHP_EOL.'ERROR: '.$Exception->getMessage().PHP_EOL;
}

echo PHP_EOL;