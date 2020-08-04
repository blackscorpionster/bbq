<?php
declare(strict_types=1);

namespace src\service;

use src\bbq\DbHandler;
use src\bbq\ActionHandler;
use src\bbq\SessionHandler;
use src\config\App;
use src\entity\User;
use src\exception\EntityNotFoundException;

class AuthService {
    private DbHandler $dbHandler;
    private ActionHandler $actionHandler;
    private SessionHandler $sessionHandler;

    public function __construct(DbHandler $dbHandler, ActionHandler $actionHandler, SessionHandler $sessionHandler) {
        $this->dbHandler = $dbHandler;
        $this->actionHandler = $actionHandler;
        $this->sessionHandler = $sessionHandler;
    }

    /**
     * @return User
     * @throws EntityNotFoundException
     */
    public function validateCredentials(): User {
        $request = $this->actionHandler->getRequest();
        $userName = $request['email'];
        $password = $request['password'];

        $pwdPeppered = hash_hmac("sha256", $password, App::PASS_PEPPER);

        $user = $this->dbHandler->runNativeSql("SELECT * FROM sysuser WHERE email = :?", $userName);

        if (empty($user)) {
            throw new EntityNotFoundException("User not found");
        }

        if (\password_verify($pwdPeppered, $user[0]['password'])) {
            $sysUser = new User($user[0]);
            $this->sessionHandler->set('_SYS_USER', $sysUser);
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            return $sysUser;
        }

        throw new EntityNotFoundException("Invalid password");
    }
}