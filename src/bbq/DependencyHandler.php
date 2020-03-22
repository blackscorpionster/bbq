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

    // https://www.php.net/manual/en/book.reflection.php
    /**
     * Handles dependency of object type only
     */
    private function instantiateClass(): void {
        try {
            $refelectionClass = new \ReflectionClass($this->classPath);
        } catch (\Throwable $exception) {
            throw new \Exception("Could not read class. Error: " . $exception->getMessage());
        }

        // https://www.php.net/manual/en/reflectionclass.getconstructor.php
        $constructor = $refelectionClass->getConstructor();

        // Class has no constructor, or empty it can be initialized immediately
        if (!$constructor instanceof \ReflectionMethod || empty($constructor->getParameters())) {
            try {
                $class = new $this->classPath();
                $this->classInstance = $class;
                return;
            } catch (\Throwable $exception) {
                throw new \Exception("Could not initialise class. Error: " . $exception->getMessage());
            }
        }

        /**
         * @var \ReflectionParameter[] $parameters
         */
        $parameters = $constructor->getParameters();

        $constructorParams = [];
        foreach($parameters as $idx => $parameter) {
            if (is_object($parameter->getClass())) {
                $constructorParams[] = ['class' => $parameter->getClass()->getName()];
            } else {
                throw new \Exception("only object injection supported");
                // https://www.php.net/manual/en/reflectionparameter.gettype.php
                //$constructorParams[] = [$parameter->getType()->getName() => $parameter->getName()];
            }
        }
        $classParams = [];

        foreach($constructorParams as $idx => $paramDetails) {
            $classParam = $paramDetails["class"];
            $handledClass =  new DependencyHandler($classParam);
            $classParams[] = $handledClass->getClassInstance();
        }

        $this->classInstance = $refelectionClass->newInstanceArgs($classParams);
        return;        
    }

    /**
     * Get the value of classInstance
     */ 
    public function getClassInstance(): Object
    {
        return $this->classInstance;
    }
}
