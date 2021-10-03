<?php

namespace app\Http\Controllers;

use app\core\Application;
use app\core\Request;
use app\Models\User;

//require_once './core/helpers/session_helper.php';

class AuthController
{

//    private User $user;

    /**
     * AuthController constructor.
     */
//    public function __construct()
//    {
//        $this->user = new User();
//    }

    public function register(Request $request): string
    {
        if ($request->isPost()) {

            $body = $request->getBody();

            $user = new User();
            $user->setUserDetails($body);

            echo $user->userName();

            $user->register();
        }

        return "inside the auth controller";
    }
}

//$init = new AuthController();
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    switch ($_POST['type']) {
//        case 'register':
//            $init->register();
//            break;
//    }
//}