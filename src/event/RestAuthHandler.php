<?php
declare(strict_types=1);

namespace src\event;

use src\bbq\ActionHandler;

class RestAuthHandler {
    private ActionHandler $actionHandler;
    public function __construct(ActionHandler $request) {
        print"<pre> EVENT !! ";
        print_r($request);
        $this->actionHandler = $request;
    }

    public function checkCredentials() {
        die("HI MM");
    }
}