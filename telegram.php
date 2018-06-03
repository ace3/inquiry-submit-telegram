<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$bot_api_key = getenv('BOT_API_KEY');
$bot_username = getenv('BOT_USERNAME');
$chat_id = getenv('BOT_CHAT_ID');

$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

function sendMessage($message, $chat_id = '553617256')
{
    try {
        $result = Longman\TelegramBot\Request::sendMessage(['chat_id' => $chat_id, 'text' => $message]);

    } catch (Longman\TelegramBot\Exception\TelegramException $e) {

    }
}
