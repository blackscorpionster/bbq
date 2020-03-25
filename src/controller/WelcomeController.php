<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;
use src\bbq\DbHandler;

class WelcomeController {
    private ActionHandler $actionHandler;

    private DbHandler $dbHandler;

    public function __construct(ActionHandler $actionHandler, DbHandler $dbHandler) {
        $this->actionHandler = $actionHandler;
        $this->dbHandler = $dbHandler;
    }

    public function welcome(): void {
        print_r("Hi");
    }

    public function welcomeUser(string $userName): void {
        print"<pre>";
        print_r($this->actionHandler->getFiles());
        print_r($this->dbHandler->runNativeSql( "SELECT * FROM app_user WHERE cod_country in (:?, :?);" , "CO'", 'CC'));
    }
}
