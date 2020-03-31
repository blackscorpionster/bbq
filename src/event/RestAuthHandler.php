<?php
declare(strict_types=1);

namespace src\event;

use src\bbq\SystemEvent;

class RestAuthHandler {
    public function __construct(SystemEvent $event) {
        print"<pre> EVENT !! ";
        print_r($event);
    }

    public function checkCredentials() {
        die("HI");
    }
}