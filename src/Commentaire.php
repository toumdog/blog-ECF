<?php

namespace ECF;


class Commentaire {
    private $id;
    private $name;
    private $email;
    private $body;
    private $createdAt;
    private $postId;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function getCreatedAt() {
        $date = new \DateTime($this->createdAt);
        return $date->format('d/m/Y H:i:s');
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getPostId() {
        return $this->postId;
    }

    public function setPostId($postId) {
        $this->postId = $postId;
        return $this;
    }

}
