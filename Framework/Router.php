<?php


namespace Framework;

use App\Controllers\ErrorController;

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

     public function route($method, $uri)
     {
         foreach ($this->routes as $route) {
             if ($route["uri"] === $uri && $route["method"] === $method) {
     
                 $controller = "App\\Controllers\\" . $route["controller"];
                 $controllerMethod = $route["controllerMethod"];
     
                 if (!class_exists($controller)) {
                     ErrorController::notFound("Controller not found: $controller");
                     return;
                 }
     
                 $controllerInstance = new $controller();
     
                 if (!method_exists($controllerInstance, $controllerMethod)) {
                     ErrorController::notFound("Method '$controllerMethod' not found in $controller");
                     return;
                 }
     
                 $controllerInstance->$controllerMethod();
                 return;
             }
         }
     
         // No matching route found, trigger 404
         ErrorController::notFound();
     }
     
}
