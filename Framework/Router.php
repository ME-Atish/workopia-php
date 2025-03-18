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

    public function route($uri)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        foreach ($this->routes as $route) {

            // Split the current URI into segments
            $uriSegment = explode("/", trim($uri, "/"));
            // Split the route URI into segments
            $routeSegment = explode("/", trim($route['uri'], "/"));

            $match = true;

            // Check if number of segment match
            if (count($uriSegment) === count($routeSegment) && strtoupper($route['method']) === $requestMethod) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegment); $i++) {
                    // If the uri's do not match and there is no params
                    if ($routeSegment[$i] !== $uriSegment[$i] && !preg_match('/\{(.+?)\}/',  $routeSegment[$i])) {
                        $match = false;
                        break;
                    }

                    // Check for the param and add to $params array
                    if (preg_match('/\{(.+?)\}/',  $routeSegment[$i], $matches)) {

                        $params[$matches[1]] = $uriSegment[$i];
                    }
                }
                if ($match) {
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

                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        // No matching route found, trigger 404
        ErrorController::notFound();
    }
}
