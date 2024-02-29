<?php

namespace ECF;


class DeleteComment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function execute($commentId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM comments WHERE id = :id");
            return $stmt->execute(['id' => $commentId]);
        } catch (\Exception $e) {
            return false;
        }
    }
}

