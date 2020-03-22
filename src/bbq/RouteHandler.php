<?php
declare(strict_types=1);

namespace src\bbq;
use src\bbq\Route;
use src\bbq\ActionHandler;
use src\bbq\DependencyHandler;

class RouteHandler {
    private Route $route;
    private ActionHandler $actionHandler;

    public function __construct(ActionHandler $actionHandler) {
        $this->actionHandler = $actionHandler;
        $this->route = $this->actionHandler->getRoute();
    }

    public function call(): void
    {
        try {
            $return = $this->invokeV1();
        } catch (\Throwable $exception) {
            $return = $this->invokeV2();
        }
        
    }

    private function invokeV1() {
        $params = array_values(array_filter(
            $this->route->getRouteParts(), 
            fn($key) => 0 === strpos($key, ":"), 
            ARRAY_FILTER_USE_KEY
        ));

        $class = $this->route->getClass();
        $classInstance = new $class();

        // Invokes controller method and returns to cl
        echo(call_user_func_array(
            [$classInstance, $this->route->getMethod()],
            $params
        ));exit();
    }

    private function invokeV2() {
        $params = $this->route->getRouteParts();

        $class = $this->route->getClass();

        $classHandler = new DependencyHandler($class);

        $classInstance = $classHandler->getClassInstance();

        $reflection = new \ReflectionMethod($classInstance, $this->route->getMethod());

        $pass = array();

        foreach($reflection->getParameters() as $param)
        {
            if (ActionHandler::CLASS_NAME_AS_PARAMETER === $param->getName()) {
                $pass[] = $this->actionHandler;
                continue;
            }

            $currentParam = ":" . $param->getName();

            /**
             *  @var $param ReflectionParameter
             */
            $pass[] = $params[$currentParam] ?? $param->getDefaultValue();
        }

        // Invokes controller method and returns to cl
        echo($reflection->invokeArgs($classInstance, $pass));
        exit();
    }
}
