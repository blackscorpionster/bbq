<?php

declare(strict_types=1);

require_once("src/bbq/Autoload.php");

use src\bbq\ActionHandler;
use src\bbq\Route;
use src\bbq\RouteHandler;
use src\config\Routes;

$actionManager = new ActionHandler(new Routes());

if (!$actionManager->getRoute() instanceof Route) {
    throw new \Exception("Url not found");
}

$routeHandler = new RouteHandler($actionManager->getRoute());
$routeHandler->call();