<?php
declare(strict_types=1);

namespace src\bbq;
use src\config\Events;

class SystemEventHandler {

    public function __construct(Events $events) {
        $systemEvents = $events->getEvents();
        print"<pre>";
        print_r($systemEvents);
    }
}
