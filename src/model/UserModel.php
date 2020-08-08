<?php
declare(strict_types=1);
namespace src\model;

class UserModel {
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $email;

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): UserModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName): UserModel
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName): UserModel
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email): UserModel
    {
        $this->email = $email;

        return $this;
    }
}
