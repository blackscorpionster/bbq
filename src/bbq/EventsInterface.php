<?php

namespace src\bbq;

interface EventsInterface {
    public function addEvent(AbstractEvent $event);
    public function getEvents();
}