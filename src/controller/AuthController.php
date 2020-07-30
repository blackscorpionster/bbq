<?php
declare(strict_types=1);

namespace src\controller;

use src\bbq\TemplateHandler;
use src\bbq\ActionHandler;
use src\service\AuthService;

class AuthController {
    private TemplateHandler $templateHandler;
    private ActionHandler $actionHandler;
    private AuthService $authService;

    public function __construct(ActionHandler $actionHandler, TemplateHandler $templateHandler, AuthService $authService) 
    {
        $this->templateHandler = $templateHandler;
        $this->actionHandler = $actionHandler;
        $this->authService = $authService;
    }

    public function login() 
    {
        $this->templateHandler->setTemplate('login.tpl.html');
        $this->templateHandler->render();
    }

    public function auth()
    {
        $this->authService->validateCredentials();
        $origin = $this->actionHandler->getHeaders();
        header(\sprintf("Location: %s/%s", $origin['Origin'], 'welcome'));
        exit;
    }
}
