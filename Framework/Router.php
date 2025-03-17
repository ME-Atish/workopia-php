<?php


namespace Framework;

class Router
{
    protected $routes = [];

    public function registerRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode("@", $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add GET route
     * 
     * @param string $uri
     * @param string $controller
     * 
     * @return void
     */

    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add POST route
     * 
     * @param string $uri
     * @param string $controller
     * 
     * @return void
     */

    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add PUT route
     * 
     * @param string $uri
     * @param string $controller
     * 
     * @return void
     */

    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * 
     * @return void
     */

    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    /**
     * Route the request
     * 
     * @param string $method
     * @param string $uri
     * 
     * @return void
     */

    /**
     * @param int $httpCode
     * 
     * @return void
     */
    public function error($httpCode = 404)
    {
        http_response_code($httpCode);
        loadView("error/{$httpCode}");
        exit;
    }

    public function route($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === $method) {

                $controller = "App\\Controllers\\" . $route["controller"];
                $controllerMethod = $route["controllerMethod"];

                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod();
            }
        }
        $this->error();
    }
}
