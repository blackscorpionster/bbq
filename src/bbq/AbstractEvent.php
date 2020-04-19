<?php 
declare(strict_types=1);

namespace src\bbq;

abstract class AbstractEvent {
    protected array $parameters = [];

    protected string $eventName;

    protected string $classPath;

    protected string $method;

    abstract function on(string $eventName): self;

    abstract function call(string $method, string $classPath): self;

    public function addStringParameter(string $key, ?string $value): self
    {
        $this->parameters[$key] = $value;
    }

    public function addDoubleParameter(string $key, ?Float $value): self
    {
        $this->parameters[$key] = $value;
    }

    public function addIntergerParameter(string $key, ?int $value): self 
    {
        $this->parameters[$key] = $value;
    }

    public function addArrayParameter(string $key, ?int $value): self 
    {
        $this->parameters[$key] = $value;
    }

    public function addObjectParameter(string $key, ?Object $value): self
    {
        $this->parameters[$key] = $value;
    }

    public function getEventName(): string {
        return $this->eventName;
    }

    public function getClassPath(): string {
        return $this->classPath;
    }

    public function getMethod(): string {
        return $this->method;
    }
}
