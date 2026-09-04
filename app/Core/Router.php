<?php
namespace App\Core;

class Router
{
    private static $routes = [];

    public static function get($route, $action)
    {
        self::addRoute('GET', $route, $action);
    }

    public static function post($route, $action)
    {
        self::addRoute('POST', $route, $action);
    }

    public static function put($route, $action)
    {
        self::addRoute('PUT', $route, $action);
    }

    public static function delete($route, $action)
    {
        self::addRoute('DELETE', $route, $action);
    }

    private static function addRoute($method, $route, $action)
    {
        // Convert route to regex, e.g., /user/{id} to /user/([^/]+)
        $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', $route);
        $routeRegex = '#^' . $routeRegex . '$#';
        
        self::$routes[] = [
            'method' => $method,
            'route' => $routeRegex,
            'action' => $action
        ];
    }

    public function dispatch($url, $method)
    {
        $url = '/' . ltrim($url, '/');
        
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match($route['route'], $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->executeAction($route['action'], $params);
                return;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        require_once APP_PATH . '/../views/errors/404.php';
    }

    private function executeAction($action, $params)
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
        } else if (is_array($action)) {
            $controllerName = $action[0];
            $methodName = $action[1];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    throw new \Exception("Method {$methodName} not found in {$controllerName}");
                }
            } else {
                throw new \Exception("Controller {$controllerName} not found");
            }
        }
    }
}
