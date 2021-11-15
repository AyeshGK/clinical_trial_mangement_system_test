<?php

namespace app\Http\Controllers;

use app\core\BaseController;
use app\core\Request;

class SiteController extends BaseController
{
    public function home(): string
    {
        return $this->renderView('home', 'main');
    }

    public function notFound(): string
    {
        return $this->renderView('notFound', 'main');
    }
}