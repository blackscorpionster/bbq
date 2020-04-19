<?php

declare(strict_types=1);

require_once("src/bbq/Autoload.php");

use src\bbq\ActionHandler;
use src\bbq\Route;
use src\bbq\RouteHandler;
use src\config\Routes;
use src\bbq\SystemEventHandler;
use src\config\Events;

$actionHandler = new ActionHandler(new Routes());

if (!$actionHandler->getRoute() instanceof Route) {
    throw new \Exception("Url not found");
}

// pre controller events
$evenHandler = new SystemEventHandler(new Events(), $actionHandler);

$routeHandler = new RouteHandler($actionHandler);
$routeHandler->call();
