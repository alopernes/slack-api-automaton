<?php
require __DIR__ . '/vendor/autoload.php';
use JoliCode\Slack\Api\Model\ObjsUser;
use JoliCode\Slack\ClientFactory;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$slackSpaceUrl = getenv('SLACK_SPACE_URL');
$accessToken = getenv('SLACK_ACCESS_TOKEN');
$client = ClientFactory::create($accessToken);
$users = [];

print 'Enter Job Number: ';
$jobNumber = trim(fgets(STDIN));

print 'Enter Slack Name: ';
$name = trim(fgets(STDIN));

print 'Enter Email Address: ';
$email = trim(fgets(STDIN));

print "##### STARTING #####\n";

$clienInfo = $client->authTest();
$clientInfoId = $clienInfo->getUserId();
$user = $client->usersLookupByEmail(['email' => $email]);

if ($user->getOk()) {
    if ($jobNumber && $name) {
        $slackName = strtolower($jobNumber. '-' . $name);
    } else {
        print "\nPlease input values correctly.\n";
        exit;
    }

    $response = $client->channelsCreate(['name' => $slackName]);
    if($response->getOk()) {
        $userId = $user->getUser()->getId();
        $channelId = $response->getChannel()->getId();
        $channelInvite = $client->channelsInvite(['user' => $userId, 'channel' => $channelId]);

        if ($clientInfoId != $userId) {
            $client->channelsLeave(['channel' => $channelId]);
        }

        print "\n##### SLACK URL : ". $slackSpaceUrl . $channelId;
    } else {
        print "\n##### Something went wrong! #####\n";
        var_dump($response);
        exit;
    }
} else {
    print "\n##### Something went wrong! #####\n";
    var_dump($user);
    exit;
}

print "\n##### END #####\n";