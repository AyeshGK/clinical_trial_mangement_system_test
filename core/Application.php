<?php

namespace app\core;


use app\core\exceptions\NotFoundException;
use app\Http\Controllers\SiteController;

class Application
{
    private Request $request;
    private Response $response;
    private Router $router;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function routing(): Router
    {
        return $this->router;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (NotFoundException $error) {
            $this->response->setStatusCode("404");
            echo (new SiteController())->notFound();
            echo $error;
        } catch (\Exception $error) {
            echo $error;
        }
    }
}