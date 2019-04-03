# Slack API Automaton

## Installation

PHP dependencies are managed via Composer and are committed into this
repository because they're deployed to the server via the repository.

This is only runnable on terminal.

#### Composer Installation
~~~
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
~~~

You can then install the project dependencies using the following command: 
~~~
composer install
~~~

### Before Starting
You need to create an application in slack.
Visit url : https://api.slack.com/apps

1. Create an application
    ~~~
    Name : 
    Development Slack Workspace :
    ~~~

2. Enable Incoming Webhooks

3. Install your app to your workspace.
    Enable slack permission scope :
    ~~~
    channels:read
    channels:write
    incoming-webhook
    users:read
    users:read.email
    ~~~

4. Get the Oauth token to be used on ENV file [ Starts with xoxp ].

#### Env File
~~~
SLACK_SPACE_URL = "https://automaton-archie.slack.com/messages/"
SLACK_ACCESS_TOKEN = ""
~~~

#### Run script
To create project channel in slack:
~~~
php create.php
~~~

To archive project channel in slack:
~~~
php archive.php
~~~

**Enjoy !**