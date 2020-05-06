<?php
declare(strict_types=1);

namespace src\bbq;

class Route {
    public const WEB_API = 'WEB';
    public const REST_API = 'REST';

    private string $name;
    private string $url;
    private string $requestMethod;
    private string $class;
    private string $method;
    private string $apiType;
    private array $routeParts;

    /**
     * Route constructor.
     * @param string $name
     * @param string $url
     * @param string $requestMethod
     * @param string $class
     * @param string $method
     * @param string $apiType
     * @throws \Exception
     */
    public function __construct(
        string $name,
        string $url,
        string $requestMethod,
        string $class,
        string $method,
        string $apiType = self::WEB_API
    )
    {
        $classExists = \class_exists($class);
        if (false === $classExists) {
            throw new \Exception('Unknown class ' . $class);
        }

        try {
            $classProps = new \ReflectionClass($class);
        } catch (\Throwable $exception) {
            throw new \Exception("Could not read class. Error: " . $exception->getMessage());
        }

        // TODO
        // Replace this with a foreach + break;
        $classMethod = current(array_filter($classProps->getMethods(), function(\ReflectionMethod $classMethod) use ($method) {
            return $method === $classMethod->getName();
        }));

        if (!$classMethod->getName() === $method) {
            throw new \Exception('Unknown action ' . $method);
        }

        if (!in_array($apiType, [self::WEB_API, self::REST_API])) {
            throw new \Exception('Unknown api type ' . $apiType);
        }
        
        $this->name = $name;
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->class = $class;
        $this->method = $method;
        $this->apiType = $apiType;
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
     * @param array $routeParts
     * @return $this
     */
    public function setRouteParts(array $routeParts): self
    {
        $this->routeParts = $routeParts;

        return $this;
    }

    /**
     * Get the value of apiType
     */ 
    public function getApiType()
    {
        return $this->apiType;
    }
}
