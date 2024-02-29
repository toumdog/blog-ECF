<?php
namespace ECF;

class Article {
    private $id;
    private $title;
    private $body; 
    private $createdAt; 
    private $userId; 

    public function displayTitle() {
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }

    public function displayBody() {
        return htmlspecialchars($this->body, ENT_QUOTES, 'UTF-8');
    }

    public function displayCreatedAt() {
        $date = new \DateTime($this->createdAt);
        return $date->format('d/m/Y H:i:s');
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of body
     */ 
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */ 
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
