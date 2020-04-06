<?php

declare(strict_types=1);

namespace src\bbq;

use src\bbq\AbstractEvent;

class SystemEvent extends AbstractEvent {
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

    private string $systemEvent;
    private string $classPath;
    private string $method;

    public function on(string $systemEvent): self {
        if (false === \in_array($systemEvent, self::SYSTEM_EVENTS)) {
            throw new \Exception("Invalid system event");
        }
        $this->systemEvent = $systemEvent;
        return $this;
    }

    public function call(string $method, string $classPath): self {
        if (empty($this->systemEvent)) {
            throw new \Exception("System event not found");
        }

        if (!class_exists($classPath, true)) {
            throw new \Exception("Class " . $classPath . " not found");
        }

        $this->classPath = $classPath;
        $this->method = $method;

        return $this;
    }
}
