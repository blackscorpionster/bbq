<?php
declare(strict_types=1);

namespace src\event;
use src\bbq\ActionHandler;

class WebAuthHandler {

    private ActionHandler $actionHandler;

    public function __construct(ActionHandler $actionHandler) {
            $this->actionHandler = $actionHandler;
    }

    public function checkCredentials()
    {
        print("Checking web cred");
    }
}