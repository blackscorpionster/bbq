<?php
declare(strict_types=1);

namespace src\bbq;

class UploadedFile {
    private $name = '';
    private $type = '';
    private $tmpName = '';
    private $error = '';
    private $size = '';

    public function __construct(array $fileInfo) {
        $this->name = $fileInfo["name"];
        $this->type = $fileInfo["type"];
        $this->tmpName = $fileInfo["tmp_name"];
        $this->error = $fileInfo["error"];
        $this->size = $fileInfo["size"];
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the value of tmpName
     */ 
    public function getTmpName(): string
    {
        return $this->tmpName;
    }

    /**
     * Get the value of error
     */ 
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * Get the value of size
     */ 
    public function getSize(): int
    {
        return $this->size;
    }
}
