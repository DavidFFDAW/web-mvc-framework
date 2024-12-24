<?php

class Controller
{
    protected function addJs($js)
    {
        if (file_exists($js)) {
            echo "<script src='" . str_replace(ROOT, '', $js) . "'></script>";
        }
    }

    protected function addCss($css)
    {
        if (file_exists($css)) {
            echo "<link rel='stylesheet' href='" . str_replace(ROOT, '', $css) . "'>";
        }
    }

    /**
     * function to render a specific view
     *
     * @param [type] $route must be folder dot separated like blog.id -> blog/id...
     * @return void
     */
    public function view($route, $vars = [])
    {
        $name = str_replace('.', '/', $route);
        if (file_exists(ROOT . "/views/$name/page.view.php")) {
            // add view vars to the view
            extract($vars);
            require_once ROOT . "/views/shared/header.php";
            $this->addCss(ROOT . "/views/$name/page.style.css");
            require_once ROOT . "/views/$name/page.view.php";
            $this->addJs(ROOT . "/views/$name/page.script.js");
            require_once ROOT . "/views/shared/footer.php";
        } else {
            http_response_code(404);
            echo "Error 404: Vista no encontrada.";
            exit;
        }
    }

    public function json($data, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($data));
    }
}
