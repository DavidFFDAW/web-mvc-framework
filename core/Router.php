<?php

class Router
{
    private $routes = [];
    private $currentGuards = [];

    public function get($path, $handler, $guards = [])
    {
        $this->addRoute('GET', $path, $handler, array_merge($this->currentGuards, $guards));
    }

    public function post($path, $handler, $guards = [])
    {
        $this->addRoute('POST', $path, $handler, array_merge($this->currentGuards, $guards));
    }

    private function addRoute($method, $path, $handler, $guards)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler, // Puede ser un closure o un array ['Controlador', 'método']
            'guards' => $guards,
        ];
    }

    public function group($guards, $callback)
    {
        $previousGuards = $this->currentGuards;
        $this->currentGuards = array_merge($this->currentGuards, $guards);

        call_user_func($callback);

        $this->currentGuards = $previousGuards;
    }

    private function matchRoute($uri, $path)
    {
        // Convertir {param} en una expresión regular
        $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $path);
        $pattern = "@^" . $pattern . "$@";

        return preg_match($pattern, $uri, $matches) ? $matches : false;
    }

    private function handle($handler, $route)
    {
        if (is_array($handler)) {
            [$Controller, $method] = $handler;
            $controller = new $Controller();

            if (class_exists($Controller) && method_exists($controller, $method)) {
                $matches = $this->matchRoute($_SERVER['REQUEST_URI'], $route['path']);
                array_shift($matches); // Eliminar la coincidencia completa
                call_user_func_array([$controller, $method], $matches);
            } else {
                http_response_code(500);
                echo "Error en la ruta: Controlador o método no encontrado.";
            }

            if (!class_exists($Controller)) {
                http_response_code(500);
                echo "Error en la ruta: Controlador no encontrado.";
            }
        }
    }

    public function dispatch($request, $method)
    {
        $uri = $request->path();
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($uri, $route['path'])) {
                foreach ($route['guards'] as $guard) {
                    if (method_exists($guard, 'handle')) {
                        $success = $guard::handle($uri);
                        if (!$success) return;
                    }
                }

                $this->handle($route['handler'], $route);
                return;
            }
        }

        http_response_code(404);
        echo "Página no encontrada.";
    }
}
