<?php

declare(strict_types=1);

namespace src\bbq;

use src\bbq\AbstractEvent;

class SystemEvent extends AbstractEvent {
    public const REST_ACTION = Route::REST_API;
    public const WEB_ACTION = Route::WEB_API;
    public const POST_REQUEST = 'POST';
    public const GET_REQUEST = 'GET';

    public const SYSTEM_EVENTS = [
        self::REST_ACTION,
        self::WEB_ACTION,
        self::POST_REQUEST,
        self::GET_REQUEST,
    ];

    public function on(string $systemEvent): self {
        if (false === \in_array($systemEvent, self::SYSTEM_EVENTS)) {
            throw new \Exception("Invalid system event");
        }
        $this->eventName = $systemEvent;
        return $this;
    }

    public function call(string $method, string $classPath): self {
        if (empty($this->eventName)) {
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
