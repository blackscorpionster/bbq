<?php

namespace src\bbq;

class SystemEvent extends AbstractEvent {
    private string $systemEvent;
    private string $classPath;
    private string $method;

    public const REST_ACTION_SYSTEM_EVENT = 'restAction';
    public const WEB_ACTION_SYSTEM_EVENT = 'webAction';
    public const POST_REQUEST_SYSTEM_EVENT = 'postRequest';
    public const GET_REQUEST_SYSTEM_EVENT = 'getRequest';

    public const SYSTEM_EVENTS = [
        self::REST_ACTION_SYSTEM_EVENT,
        self::WEB_ACTION_SYSTEM_EVENT,
        self::POST_REQUEST_SYSTEM_EVENT,
        self::GET_REQUEST_SYSTEM_EVENT,
    ];

    public function on(string $systemEvent) {
        if (false === \in_array($systemEvent, AbstractEvent::SYSTEM_EVENTS)) {
            throw new Exception("Invalid system event");
        }
        $this->systemEvent = $systemEvent;
    }

    public function call(string $method, string $classPath) {
        if (empty($this->systemEvent)) {
            throw new Exception("System event not found");
        }

        if (!class_exists($classPath, false)) {
            throw new Exception("Class not found");
        }

        $this->classPath = $classPath;
        $this->method = $method;
    }
}