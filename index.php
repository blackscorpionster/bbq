<?php

declare(strict_types=1);

require_once("src/bbq/Autoload.php");

use src\bbq\ActionHandler;
use src\bbq\Route;
use src\bbq\RouteHandler;
use src\bbq\SystemEventHandler;
use src\bbq\SessionHandler;
use src\config\Routes;
use src\config\Events;

$sessionHandler = new SessionHandler();

$actionHandler = new ActionHandler(new Routes());

header("Access-Control-Allow-Origin: *");
if ("OPTIONS" === $actionHandler->getMethod()) {
    return $actionHandler->respondPreflight();
}

if (!$actionHandler->getRoute() instanceof Route) {
    throw new \Exception("Url not found");
}

// pre controller events
$evenHandler = new SystemEventHandler(new Events(), $actionHandler);

$routeHandler = new RouteHandler($actionHandler);

$routeHandler->call();
