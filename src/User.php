<?php

namespace ECF;

class User{
    private int $id;
    public string $name;
    public string $username;
    public string $email;
    private string $password;
    private string $role;


    public function verifMDP (string $mdp): bool{

        return $this->password=== $mdp;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}