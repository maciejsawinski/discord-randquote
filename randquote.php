<?php

ini_set('memory_limit', '200M');
include __DIR__.'/vendor/autoload.php';
include __DIR__.'/randquote/Config.php';

$config = new Config;
$discord = new \Discord\Discord([
    'token' => $config->getToken(),
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;
  
    // Listen for events here
    $discord->on('message', function ($message) {
        echo "Recieved a message from {$message->author->username}: {$message->content}", PHP_EOL;
    });
});

$discord->run();