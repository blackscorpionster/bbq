<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;

class WelcomeController {
    public function welcome(): void {
        print_r("Hi");
    }

    public function welcomeUser(ActionHandler $actionHandler, string $userName): void {
        print_r($actionHandler->getQuery());
        print($userName);die("Iside controller baby");
    }
}
