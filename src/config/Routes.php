<?php
declare(strict_types=1);

namespace src\config;

use src\bbq\Route;

class Routes {
    private array $routes;

    public function __construct() {
        $this->routes = [
            new Route('login', 
                '/', 
                'GET', 
                'src\controller\authController', 
                'login'
            ),
            new Route('auth', 
                '/auth', 
                'POST', 
                'src\controller\authController', 
                'auth'
            ),
            new Route('logout', 
                '/logout', 
                'POST', 
                'src\controller\authController', 
                'logout'
            ),
            new Route('welcome', 
                '/welcome', 
                'GET', 
                'src\controller\WelcomeController', 
                'welcome'
            ),
            new Route('welcome user', 
                '/welcome/:userName', 
                'POST', 
                'src\controller\WelcomeController', 
                'welcomeUser'
            ),
            new Route('Register company user', 
                '/register/user/company/:companyId/user/:userId', 
                'GET', 
                'src\controller\RegisterController',
                'registerUser'
            ),
            new Route(
                'Client user query',
                '/register/user/client/:clientId/user/:userName',
                'POST',
                'src\controller\RegisterController', 
                'clientUser'
            ),
            new Route (
                'REST Api login',
                '/api/login',
                'POST',
                'src\controller\API\AuthController',
                'login',
                Route::REST_API
            ),
            new Route (
                'WEB Api login',
                '/login',
                'POST',
                'src\controller\AuthController',
                'login'
            ),
            new Route(
                'Save bar code',
                '/barcode/save',
                'POST',
                'src\controller\BarcodeController',
                'save'
            )
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
