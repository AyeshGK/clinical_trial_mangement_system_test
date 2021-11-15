<?php

namespace app\core\helpers;

/*uncompleted*/

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => $flashMessage) {
            $flashMessage['remove'] = true;

        }

//        $_SESSION[self::]
    }


}