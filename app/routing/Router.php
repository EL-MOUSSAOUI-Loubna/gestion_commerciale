<?php
class Router {
    private $routes = [];

    public function add($method, $path, $controllerAction) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controllerAction' => $controllerAction
        ];
    }

    public function dispatch($requestUri, $requestMethod) {
        // Strip the "/stage" prefix from the request URI
        $requestUri = preg_replace('/\/stage/', '', $requestUri, 1);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestUri)) {
                list($controller, $action) = explode('@', $route['controllerAction']);
                if (class_exists($controller) && method_exists($controller, $action)) {
                    $controllerInstance = new $controller();
                    $controllerInstance->$action();
                    return;
                }
            }
        }
        $this->notFound();
    }

    private function matchPath($routePath, $requestUri) {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestUri, '/'));

        // Debug statements to check the values
         echo "Route Parts: "; print_r($routeParts); echo "<br>";
         echo "Request Parts: "; print_r($requestParts); echo "<br>";

        // Ensure both arrays have the same number of elements
        if (count($routeParts) !== count($requestParts)) {
            return false;
        }
        if (empty($routeParts)) {
            return false;
        }

        foreach ($routeParts as $index => $part) {
            if (!isset($requestParts[$index]) || ($part !== $requestParts[$index] && $part[0] !== ':')) {
                return false;
            }
        }

        return true;
    }

    private function notFound() {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
