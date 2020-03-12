<?php
declare(strict_types=1);

namespace src\controller;

class RegisterController {
    public function registerUser(int $companyId, int $userId) {
        print(">>> " . $companyId . " >>> " . $userId);
        die("Register controller");
    }
}