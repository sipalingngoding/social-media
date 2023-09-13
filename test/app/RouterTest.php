<?php

namespace SipalingNgoding\MVC\app;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public Router $router;
    public static int $count = 0;
    public function setUp(): void
    {
        $this->router = new Router();
        self::$count++;
    }

    public static function additionalProvider():array
    {
        return [
            ['/','homeController','home',[['autMiddle','mustLogin']]],
            ['/login','userController','login',[]],
            ['/register','userController','register',[]],
        ];
    }

    #[DataProvider('additionalProvider')]
    public function testGet(string $path, string $controller, string $function, array $middlewares):void
    {
        $this->router::get($path,[$controller,$function], $middlewares);
        $routes = $this->router::$routes;
        self::assertIsArray($routes);
        self::assertCount(self::$count,$routes);
        $route = $this->router::$routes[self::$count -1 ];
        self::assertSame($route['method'],'GET');
        self::assertSame($route['controller'],$controller);
        self::assertSame($route['function'],$function);
        self::assertSame($middlewares,$route['middlewares']);
    }

    #[DataProvider('additionalProvider')]
    public function testPost(string $path, string $controller, string $function, array $middlewares):void
    {
        $this->router::post($path,[$controller,$function], $middlewares);
        $routes = $this->router::$routes;
        self::assertIsArray($routes);
        self::assertCount(self::$count,$routes);
        $route = $this->router::$routes[self::$count - 1 ];
        self::assertSame($route['method'],'POST');
        self::assertSame($route['controller'],$controller);
        self::assertSame($route['function'],$function);
        self::assertSame($route['middlewares'],$middlewares);
    }
}
