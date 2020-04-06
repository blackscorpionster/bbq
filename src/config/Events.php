<?php

declare(strict_types=1);

namespace src\config;

use src\bbq\SystemEvent;
use src\bbq\CustomEvent;
use src\bbq\EventsInterface;
use src\bbq\AbstractEvent;

class Events implements EventsInterface {
    private array $events = [];
    public function __construct() {
        $restAuthCheck = new SystemEvent();
        $this->addEvent(
            $restAuthCheck
            ->on(SystemEvent::REST_ACTION_SYSTEM_EVENT)
            ->call('checkCredentials', 'src\event\RestAuthHandler')
        );

        $myEvent = new CustomEvent();
        $this->addEvent(
            $myEvent
            ->on("NEW_USER")
            ->call('sendEmail', 'src\event\SendEmail')
        );
    }

    public function addEvent(AbstractEvent $event) {
        $this->events[] = $event;
    }

    public function getEvents() {
        return $this->events;
    }
}
