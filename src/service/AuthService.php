<?php
declare(strict_types=1);

namespace src\service;

use src\bbq\DbHandler;
use src\bbq\ActionHandler;
use src\config\App;

class AuthService {
    private DbHandler $dbHandler;
    private ActionHandler $actionHandler;

    public function __construct(DbHandler $dbHandler, ActionHandler $actionHandler) {
        $this->dbHandler = $dbHandler;
        $this->actionHandler = $actionHandler;
    }

    public function validateCredentials(): void {
        $request = $this->actionHandler->getRequest();
        $userName = $request['email'];
        $password = $request['password'];

        $pwd_peppered = hash_hmac("sha256", $password, App::PASS_PEPPER);
        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);

        print_r(">>CREDENTIALS << " . $userName . "<>" . $password. " ----  ".$pwd_hashed);die();
    }
}