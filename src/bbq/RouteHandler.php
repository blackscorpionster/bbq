<?php
declare(strict_types=1);

namespace src\bbq;
use src\bbq\Route;

class RouteHandler {
    private Route $route;

    public function __construct(Route $route) {
        $this->route = $route;
    }

    public function call(): void
    {
        $class = $this->route->getClass();
        $classInstance = new $class();
        $params = array_values(array_filter(
            $this->route->getRouteParts(), 
            fn($key) => 0 === strpos($key, ":"), 
            ARRAY_FILTER_USE_KEY
        ));

        // print"<pre> CALLING: >>> ";
        // print_r($this->route->getRouteParts());
        // print_r($params);
        // die(" <<< PARAMS");
        $return = call_user_func_array(
            [$classInstance, $this->route->getMethod()],
            $params
        );

		print"<pre>";
        print_r($this->route->getRouteParts());
    }
}
