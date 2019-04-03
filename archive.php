<?php
require __DIR__ . '/vendor/autoload.php';
use JoliCode\Slack\Api\Model\ObjsUser;
use JoliCode\Slack\ClientFactory;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$accessToken = getenv('SLACK_ACCESS_TOKEN');
$client = ClientFactory::create($accessToken);

print 'Enter Job Number: ';
$jobNumber = trim(fgets(STDIN));

print 'Enter Name: ';
$name = trim(fgets(STDIN));

print "##### STARTING #####\n";

if ($jobNumber && $name) {
    $slackName = strtolower($jobNumber. '-' . $name);
} else {
    print "Please input values correctly.\n";
    exit;
}

$response = $client->channelsList();

foreach($response->getChannels() as $channel) {
    if ($channel->getName() == $slackName) {
        $response = $client->channelsArchive(['channel' => $channel->getId()]);
        if($response->getOk()) {
            print "\n##### Archived : ". $channel->getName() ."\n";
            exit;
        } else {
            print "\n##### Something went wrong! #####\n";
            var_dump($response);
            exit;
        }
        break;
    }
}

print "##### Channel not found! \n";
exit;