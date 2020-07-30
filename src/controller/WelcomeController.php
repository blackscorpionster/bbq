<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;
use src\bbq\DbHandler;
use src\bbq\SessionHandler;
use src\bbq\TemplateHandler;

class WelcomeController {
    private ActionHandler $actionHandler;

    private DbHandler $dbHandler;

    private SessionHandler $sessionHandler;

    private TemplateHandler $templateHandler;

    /**
     * WelcomeController constructor.
     * @param ActionHandler $actionHandler
     * @param DbHandler $dbHandler
     * @param SessionHandler $sessionHandler
     * @param TemplateHandler $templateHandler
     */
    public function __construct(
        ActionHandler $actionHandler, 
        DbHandler $dbHandler, 
        SessionHandler $sessionHandler,
        TemplateHandler $templateHandler
    )
    {
        $this->actionHandler = $actionHandler;
        $this->dbHandler = $dbHandler;
        $this->sessionHandler = $sessionHandler;
        $this->templateHandler = $templateHandler;
    }

    public function welcome() {
        $handler = $this->templateHandler->getHandler();
        $handler->assign('file', 'src/assets/views/templates/vue-dist/index.html');
        $this->templateHandler->setTemplate('index.tpl.html');
        // print "<pre>";
        // \print_r($this->templateHandler->getHandler());die();
        return $this->templateHandler->render();

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
