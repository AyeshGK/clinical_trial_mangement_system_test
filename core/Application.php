<?php

namespace app\core;


use app\core\exceptions\NotFoundException;
use app\Http\Controllers\SiteController;

class Application
{
    private Request $request;
    private Response $response;
    private Router $router;
    public static Application $app;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);

        self::$app = $this;
    }

    public function routing(): Router
    {
        return $this->router;
    }

    public function redirect($url)
    {
        $this->response->redirect($url);
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