<?php

namespace SipalingNgoding\MVC\app;

class Router
{
    public static array $routes = [];

    public static function get(string $path, array $func, array $middlewares = []):void
    {
        self::$routes[] = [
            'method' => 'GET',
            'path'=>basename($path),
            'controller'=>$func[0],
            'function'=>$func[1],
            'middlewares'=>$middlewares,
        ];
    }
    public static function post(string $path, array $func, array $middlewares = []):void
    {
        self::$routes[] = [
            'method' => 'POST',
            'path'=>basename($path),
            'controller'=>$func[0],
            'function'=>$func[1],
            'middlewares'=>$middlewares,
        ];
    }

    public static function run():void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? "/";
        $path = basename($path);

        foreach (self::$routes as $route)
        {
            if($route['method'] ===  $method && $route['path'] ===  $path)
            {
                $middlewares = $route['middlewares'];
                foreach ($middlewares as $middleware){
                    $class = new $middleware[0];
                    $func = $middleware[1];
                    $class->$func();
                }
                $controller = new $route['controller'];
                $function = $route['function'];
                $controller->$function();
                return;
            }
        }
        echo "Router Not Found";
        http_response_code(404);
    }
}
