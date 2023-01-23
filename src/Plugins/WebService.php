<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\WebAppData;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;
use Utilities\Routing\Response;
use Utilities\Routing\Utils\StatusCode;

/**
 * Class WebService
 *
 * The Class will handle the requests for the WebApp.
 *
 * @author     Shahrad Elahi <shahrad@litehex.com>
 * @link       https://github.com/telegram-bot-php/durger-king
 * @version    v1.0.0
 */
class WebService extends \TelegramBot\Plugin
{

    /**
     * @param WebAppData $webAppData
     * @return \Generator
     */
    public function onWebAppData(WebAppData $webAppData): \Generator
    {
        if ($webAppData->getRawData()['method'] == "makeOrder") {
            header('Content-Type: application/json');

            yield Request::sendMessage([
                'chat_id' => $webAppData->getUser()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Sua compra foi feita com sucesso!" . "\n\n" .
                    "Sua compra é: \n`" . $this->parseOrder($webAppData->getRawData()['order_data']) . "`" . "\n" .
                    "Sua compra vai ser entregue pra você em aproximadamente 30 minutos.",
            ]);

            Response::send(StatusCode::OK);
        }

        if ($webAppData->getRawData()['method'] == "checkInitData") {
            header('Content-Type: application/json');
            Response::send(StatusCode::OK);
        }

        if ($webAppData->getRawData()['method'] == "sendMessage") {
            header('Content-Type: application/json');

            yield Request::sendMessage([
                'chat_id' => $webAppData->getUser()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Olá Mundo!",
                ...(!$webAppData->getRawData()['with_webview'] ? [] : [
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [
                            InlineKeyboardButton::make('Abrir WebApp')->setWebApp($_ENV['RESOURCE_BASE_URL']),
                        ]
                    ])
                ])
            ]);

            Response::send(StatusCode::OK);
        }
    }

    /**
     * @param string $order
     * @return string
     */
    protected function parseOrder(string $order = '[]'): string
    {
        if ($order == '[]') {
            return 'Nada';
        }

        $order = json_decode($order, true);
        $order_text = '';
        foreach ($order as $item) {
            $order_text .= (
                $item['count'] . 'x ' .
                $this->store_items[$item['id']]['name'] . ' ' .
                $this->store_items[$item['id']]['emoji'] . ' $' .
                ($this->store_items[$item['id']]['price'] * $item['count']) . "\n"
            );
        }
        return $order_text;
    }

    /**
     * The available items in the store.
     *
     * @var array|array[]
     */
    protected array $store_items = [
        1 => [
            'name' => 'Hamburger',
            'emoji' => '🍔',
            'price' => 15,
        ],
        2 => [
            'name' => 'Batata Frita',
            'emoji' => '🍟',
            'price' => 5,
        ],
        3 => [
            'name' => 'Suco',
            'emoji' => '🥤',
            'price' => 3,
        ],
        4 => [
            'name' => 'Salada',
            'emoji' => '🥗',
            'price' => 15,
        ],
        5 => [
            'name' => 'Pizza',
            'emoji' => '🍕',
            'price' => 40,
        ],
        6 => [
            'name' => 'Sanduíche',
            'emoji' => '🥪',
            'price' => 7,
        ],
        7 => [
            'name' => 'Hot-Dog',
            'emoji' => '🌭',
            'price' => 10,
        ],
        8 => [
            'name' => 'Sorvete',
            'emoji' => '🍦',
            'price' => 6,
        ],
        9 => [
            'name' => 'Bolo',
            'emoji' => '🍰',
            'price' => 25,
        ],
        10 => [
            'name' => 'Rosquinha',
            'emoji' => '🍩',
            'price' => 5,
        ],
        11 => [
            'name' => 'Cupcake',
            'emoji' => '🧁',
            'price' => 5,
        ],
        12 => [
            'name' => 'Cookie',
            'emoji' => '🍪',
            'price' => 4,
        ],
        13 => [
            'name' => 'Sushi',
            'emoji' => '🍣',
            'price' => 4,
        ],
        14 => [
            'name' => 'Macarrão',
            'emoji' => '🍜',
            'price' => 3,
        ],
        15 => [
            'name' => 'Carne',
            'emoji' => '🥩',
            'price' => 10,
        ],
    ];

}