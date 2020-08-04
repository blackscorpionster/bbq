<?php
declare(strict_types=1);

namespace src\controller;

use src\bbq\TemplateHandler;
use src\bbq\ActionHandler;
use src\bbq\SessionHandler;
use src\service\AuthService;
use src\exception\EntityNotFoundException;
use src\entity\User;

class AuthController {
    private TemplateHandler $templateHandler;
    private ActionHandler $actionHandler;
    private AuthService $authService;
    private SessionHandler $sessionHandler;

    public function __construct(
        ActionHandler $actionHandler, 
        TemplateHandler $templateHandler, 
        AuthService $authService,
        SessionHandler $sessionHandler
    ) 
    {
        $this->templateHandler = $templateHandler;
        $this->actionHandler = $actionHandler;
        $this->authService = $authService;
        $this->sessionHandler = $sessionHandler;
    }

    /**
     * /
     */
    public function login() 
    {
        // If there is a session already, redirect to the welcome page
        if ($this->sessionHandler->get('_SYS_USER') instanceof User)
        {
            header(\sprintf("Location: %s/%s", $origin['Origin'], 'welcome'));
            exit;
        }

        // There is no session, show the login page
        $this->templateHandler->setTemplate('login.tpl.html');
        $query = $this->actionHandler->getQuery();
        $message = '';
        if (!empty($query["message"])) {
            $message = $query["message"];
        }
        $this->templateHandler->getHandler()->assign('message', $message);
        $this->templateHandler->render();
    }

    /**
     * /auth
     */
    public function auth()
    {
        $origin = $this->actionHandler->getHeaders();
        try {
            $user = $this->authService->validateCredentials();
        } catch (EntityNotFoundException $e) {
            // user auth error, redirect to the login page and show the error
            header(\sprintf("Location: %s?message=%s", $origin['Origin'], $e->getMessage()));
            exit;
        }
        
        // Auth successful, redirect to the welcome page
        header(\sprintf("Location: %s/%s", $origin['Origin'], 'welcome'));
        exit;
    }

    /**
     * /init
     */
    public function initApp() {
        if ($this->sessionHandler->exists('_SYS_USER') && $this->sessionHandler->exists('token')) {
            return \json_encode(['token' => $this->sessionHandler->get('token')]);
        }

        http_response_code(404);
        throw new \RunTimeException('Invalid session');
    }

    /**
     * /logout
     */
    public function logout() {
        $token = $this->actionHandler->getJsonData()['token'];
        if (\hash_equals($token, $this->sessionHandler->get('token'))) {
            $this->sessionHandler->destroy();
            return \json_encode(true);
        }

        http_response_code(404);
        throw new \RuntimeException("Error");
    }
}
