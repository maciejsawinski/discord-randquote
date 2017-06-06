<?php

ini_set('memory_limit', '-1');

use Discord\Discord;
use Discord\Cache\Cache;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Part;
use Discord\Parts\User\Game;
use Discord\Parts\User\User;
use React\Promise\Deferred;

include __DIR__.'/vendor/autoload.php';
include __DIR__.'/randquote/Config.php';
include __DIR__.'/randquote/Quote.php';

$config = new Config;
$discord = new \Discord\Discord([
    'token'         => $config->getToken(),
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;
  
    $game = $discord->factory(Game::class, [
        'name' => 'Say ;;commands',
    ]); 
    $discord->updatePresence($game);
    
    // Listen for events here
    $discord->on('message', function($message) use ($discord) {

        $guildId = $message->channel->guild_id;
        $channelId = $message->channel_id;
        $guild = $discord->guilds->get('id', $guildId);
        $channel = $guild->channels->get('id', $channelId);

        if ($message->content == ';;commands') {
            
            $quote = new Quote;
            $channel->sendMessage($quote->getCommands())->then(function ($message) {
                echo "The message was sent", PHP_EOL;
            })->otherwise(function ($e) {
                echo "There was an error sending the message: {$e->getMessage()}", PHP_EOL;
                echo $e->getTraceAsString() . PHP_EOL;
            });
        }
        elseif ($message->content == ';;quote') {
            
            $quote = new Quote;
            $channel->sendMessage($quote->getRandomQuote())->then(function ($message) {
                echo "The message was sent", PHP_EOL;
            })->otherwise(function ($e) {
                echo "There was an error sending the message: {$e->getMessage()}", PHP_EOL;
                echo $e->getTraceAsString() . PHP_EOL;
            });
        }
        elseif ($message->content == ';;info') {
            
            $quote = new Quote;
            $channel->sendMessage($quote->getInfo())->then(function ($message) {
                echo "The message was sent", PHP_EOL;
            })->otherwise(function ($e) {
                echo "There was an error sending the message: {$e->getMessage()}", PHP_EOL;
                echo $e->getTraceAsString() . PHP_EOL;
            });
        }
    });
});

$discord->run();