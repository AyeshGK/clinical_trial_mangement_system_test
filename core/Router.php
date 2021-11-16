<?php

namespace app\core;


use app\core\exceptions\NotFoundException;
use app\Http\Controllers\AuthController;

class Router
{
    private array $routes = [];
    private Request $request;
    private Response $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {

        $this->routes['get'][$path] = $callback;

    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws \Exception
     */
    public function resolve(): string
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;


        if ($callback === false) {
            throw new NotFoundException();
        }

//        if (is_string($callback)) {
//            return $this->renderView($callback);
//        }
//
//        echo '<pre>';
//        var_dump($callback);
//        echo '</pre>';


        if (is_array($callback)) {
            $controller = new $callback[0]();
//            echo '<pre>';
//            var_dump($controller);
//            echo '</pre>';


//            $controller->$$callback[1];
            return $controller->{$callback[1]}($this->request);
        }


        return call_user_func($callback, $this->request, $this->response);
    }


}