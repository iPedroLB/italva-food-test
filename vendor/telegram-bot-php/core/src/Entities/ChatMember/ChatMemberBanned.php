<?php

namespace TelegramBot\Entities\ChatMember;

use TelegramBot\Entities\User;
use TelegramBot\Entity;

/**
 * Class ChatMemberBanned
 *
 * @link https://core.telegram.org/bots/api#chatmemberbanned
 *
 * @method string getStatus()       The member's status in the chat, always “kicked”
 * @method User   getUser()         Information about the user
 * @method int    getUntilDate()    Date when restrictions will be lifted for this user;
 * unix time
 */
class ChatMemberBanned extends Entity implements ChatMember
{

    /**
     * @inheritDoc
     */
    protected function subEntities(): array
    {
        return [
            'user' => User::class,
        ];
    }

}
