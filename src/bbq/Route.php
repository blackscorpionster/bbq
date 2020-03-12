<?php
declare(strict_types=1);

namespace src\bbq;

class Route {
    private string $name;
    private string $url;
    private string $requestMethod;
    private string $class;
    private string $method;
    private array $routeParts;

    public function __construct(string $name, string $url, string $requestMethod, string $class, string $method) {
        $classExists = \class_exists($class);
        if (false === $classExists) {
            throw new \Exception('Unknown class ' . $class);
        }

        $classInstance = new $class();
        $methodExists = \method_exists($classInstance, $method);
        if (false === $methodExists) {
            throw new \Exception('Unknown action ' . $method);
        }
        $this->name = $name;
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->class = $class;
        $this->method = $method;
        $this->routeParts = explode('/', $this->url);
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of url
     */ 
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the value of requestMethod
     */ 
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * Get the value of class
     */ 
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Get the value of method
     */ 
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the value of routeParts
     */ 
    public function getRouteParts(): array
    {
        return $this->routeParts;
    }

    /**
     * Set the value of routeParts
     *
     * @return  self
     */ 
    public function setRouteParts(array $routeParts): self
    {
        $this->routeParts = $routeParts;

        return $this;
    }
}
