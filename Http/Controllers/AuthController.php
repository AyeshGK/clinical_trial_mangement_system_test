<?php

namespace app\Http\Controllers;


use app\core\BaseController;
use app\core\Request;
use app\Models\User;


class AuthController extends BaseController
{

    public function signUp(): string
    {
        return $this->renderView('signup', 'main');
    }

    public function register(Request $request): string
    {


        if ($request->isPost()) {

            $body = $request->getBody();

            $user = new User();
            $user->setUserDetails($body);

            echo $user->userName();

            if ($user->validate() && $user->register()) {

            }
        }

        return "inside the auth controller";
    }

    public function logIn(): string
    {
        return $this->renderView('login', 'auth');
    }
}

