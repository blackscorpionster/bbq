<?php
declare(srtcit_types=1);
namespace src\bbq;

use src\bbq\SystemEvent;

class Events {
    private array $events = [];
    public function __construct() {
        $restAuthCheck = new SystemEvent();
        $this->addEvent(
            $restAuthCheck
            ->on(SystemEvent::REST_ACTION_SYSTEM_EVENT)
            ->call('checkCredentials', 'src\event\RestAuthHandler')
        );
    }

    private function addEvent(AbstractEvent $event) {
        $this->events[] = $event;
    }
}
