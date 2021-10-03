<?php

namespace app\core;


class Application
{
    public Request $request;
    public Response $response;
    public Router $router;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $error) {
            $this->response->setStatusCode("404");
            echo $this->router->renderView('notFound');
        }
    }
}