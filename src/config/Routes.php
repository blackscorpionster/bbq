<?php
declare(strict_types=1);

namespace src\config;

use src\bbq\Route;

class Routes {
    private array $routes;

    public function __construct() {
        $this->routes = [
            new Route('welcome', 
                '/welcome', 
                'GET', 
                'src\controller\WelcomeController', 
                'welcome'
            ),
            new Route('welcome user', 
                '/welcome/:userName', 
                'GET', 
                'src\controller\WelcomeController', 
                'welcomeUser'
            ),
            new Route('Register company user', 
                '/register/user/company/:companyId/user/:userId', 
                'GET', 
                'src\controller\RegisterController', 
                'registerUser'
            ),
        ];
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
