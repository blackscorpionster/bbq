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

        try {
            $classProps = new \ReflectionClass($class);
        } catch (\Throwable $exception) {
            throw new \Exception("Could not read class. Error: " . $exception->getMessage());
        }

        // Replace this with a foreach + break;
        $classMethod = current(array_filter($classProps->getMethods(), function(\ReflectionMethod $classMethod) use ($method) {
            return $method === $classMethod->getName();
        }));

        if (!$classMethod->getName() === $method) {
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
