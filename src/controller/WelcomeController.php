<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;
use src\bbq\DbHandler;
use src\bbq\SessionHandler;

class WelcomeController {
    private ActionHandler $actionHandler;

    private DbHandler $dbHandler;

    private SessionHandler $sessionHandler;

    /**
     * WelcomeController constructor.
     * @param ActionHandler $actionHandler
     * @param DbHandler $dbHandler
     * @param SessionHandler $sessionHandler
     */
    public function __construct(ActionHandler $actionHandler, DbHandler $dbHandler, SessionHandler $sessionHandler)
    {
        $this->actionHandler = $actionHandler;
        $this->dbHandler = $dbHandler;
        $this->sessionHandler = $sessionHandler;
    }

    public function welcome(): void {
        if ($this->sessionHandler->exists('FirstValue')) {
            print("Hi First value " . $this->sessionHandler->get('FirstValue'));
        }
        $this->sessionHandler->set('FirstValue', 123);
        print_r("Hi");
    }

    /**
     * @param string $userName
     * @throws \Exception
     */
    public function welcomeUser(string $userName): void {
        print"<pre>";
        print_r($this->actionHandler->getFiles());
        print_r($this->dbHandler->runNativeSql( "SELECT * FROM app_user WHERE cod_country in (:?, :?);" , "CO'", 'CC'));
    }
}
