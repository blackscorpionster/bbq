<?php

declare(strict_types=1);

namespace src\bbq;

use src\bbq\AbstractEvent;

class CustomEvent extends AbstractEvent {
    public function on(string $customEvent): self {
        $this->eventName = $customEvent;
        return $this;
    }

    public function call(string $method, string $classPath): self {
        if (empty($this->eventName)) {
            throw new \Exception("Custom event not found");
        }

        if (!class_exists($classPath, true)) {
            throw new \Exception("Class " . $classPath . " not found");
        }

        $this->classPath = $classPath;
        $this->method = $method;

        return $this;
    }
}