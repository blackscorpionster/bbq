<?php
declare(strict_types=1);

namespace src\controller;
use src\bbq\ActionHandler;

class RegisterController {
    public function registerUser(int $companyId, int $userId) {
        print(">>> " . $companyId . " >>> " . $userId);
        die("Register controller");
    }

    public function clientUser(ActionHandler $actionHandler, int $clientId, string $userName) {
        $jsonData = $actionHandler->getJsonData();
        // return "<html><head></head><body><p> Hi " . $userName . " <span style='color: blue;'>{$clientId}</span></body></html>";
        return json_encode($jsonData);
    }
}