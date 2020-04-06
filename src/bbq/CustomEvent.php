<?php

declare(strict_types=1);

namespace src\bbq;

use src\bbq\AbstractEvent;

class CustomEvent extends AbstractEvent {
    private string $customEvent;
    private string $classPath;
    private string $method;

    public function on(string $customEvent): self {
        $this->customEvent = $customEvent;
        return $this;
    }

    public function call(string $method, string $classPath): self {
        if (empty($this->customEvent)) {
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