<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Message;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;

/**
 * Class Commands
 *
 * The Class will handle the requests for the WebApp.
 *
 * @author     Shahrad Elahi <shahrad@litehex.com>
 * @link       https://github.com/telegram-bot-php/durger-king
 * @version    v1.0.0
 */
class Commands extends \TelegramBot\Plugin
{

    /**
     * @param int $update_id
     * @param Message $message
     * @return \Generator
     */
    public function onMessage(int $update_id, Message $message): \Generator
    {
        if ($message->getText() == '/start' || $message->getText() == '/order') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "*Bem-vindo ao BOT do [PLACEHOLDER]* 🍟 \n\nPor favor toque no botão abaixo para pedir sua comida!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [
                        InlineKeyboardButton::make('Comprar Comida')->setWebApp($_ENV['RESOURCE_PATH']),
                    ]
                ])
            ]);
        }

        if ($message->getText() == '/test') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Por favor aperte no botão abaixo para comprar sua comida!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [
                        InlineKeyboardButton::make('Test')->setWebApp($_ENV['RESOURCE_PATH'] . '/demo.php'),
                    ]
                ])
            ]);
        }

        if ($message->getText() == '/help') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "Essa é a página de ajuda. Você pode usar os comandos abaixo:\n\n" .
                    "/start - Começar o BOT\n" .
                    "/order - Comprar comida\n" .
                    "/test - Testar o aplicativo\n" .
                    "/help - Mostrar essa página de ajuda"
            ]);
        }
    }

}