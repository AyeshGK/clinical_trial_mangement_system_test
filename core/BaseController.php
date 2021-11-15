<?php

namespace app\core;

abstract class  BaseController
{


    public function renderView(string $view, $layout, $params = []): string
    {
        $layoutContent = $this->getLayoutContent($layout);
        $viewContent = $this->getView($view, $params);

        return str_replace('{{body-content}}', $viewContent, $layoutContent);
    }

    private function getView($view, $params = [])
    {
        /*
         * initialize parameters
         * */
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once "../Views/$view.php";
        return ob_get_clean();
    }

    private function getLayoutContent($layout = 'main')
    {
        ob_start();
        include_once "../Views/layouts/$layout.php";
        return ob_get_clean();
    }
}