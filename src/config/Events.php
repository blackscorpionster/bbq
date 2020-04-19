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
            ->on(SystemEvent::REST_ACTION)
            ->call('checkCredentials', 'src\event\RestAuthHandler')
        );

        $webAuthCheck = new SystemEvent();
        $this->addEvent(
            $webAuthCheck
            ->on(SystemEvent::WEB_ACTION)
            ->call('checkCredentials', 'src\event\WebAuthHandler')
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
