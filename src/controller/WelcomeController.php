<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;

class WelcomeController {
    private ActionHandler $actionHandler;

    public function __construct(ActionHandler $actionHandler) {
        $this->actionHandler = $actionHandler;
    }

    public function welcome(): void {
        print_r("Hi");
    }

    public function welcomeUser(string $userName): void {
        print"<pre>";
        print_r($this->actionHandler->getFiles());
        print($userName);die("Inside controller baby");
    }
}
