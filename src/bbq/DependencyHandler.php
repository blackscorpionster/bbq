<?php
declare(strict_types = 1);

namespace src\bbq;

class DependencyHandler {
    private string $classPath;
    private Object $classInstance;
    public function __construct(string $classPath) {
        $this->classPath = $classPath;
        $this->instantiateClass();
    }

    private function instantiateClass(): void {
        try {
            $classProps = new \ReflectionClass($this->classPath);
        } catch (\Throwable $exception) {
            throw new \Exception("Could not read class. Error: " . $exception->getMessage());
        }
     
        $constructor = $classProps->getConstructor();

        print_r($constructor);die();

        if (!$constructor instanceof \ReflectionMethod) {
            try {
                $class = new $this->classPath();
                $this->classInstance = $class;
                return;
            } catch (\Throwable $exception) {
                throw new \Exception("Could not initialise class. Error: " . $exception->getMessage());
            }
        }

        $parameters = $constructor->getParameters();


        print_r($parameters);die();

        
    }

    /**
     * Get the value of classInstance
     */ 
    public function getClassInstance(): Object
    {
        return $this->classInstance;
    }
}
