<?php
declare(strict_types=1);

namespace src\config;

use src\bbq\Route;

class Routes {
    private array $routes;

    public function __construct() {
        $this->routes = [
            new Route('run_action', '/action/{id}', 'POST'),
        ];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}