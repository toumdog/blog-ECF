<?php

use ECF\Mabdd;
use ECF\Article;
use ECF\Commentaire;
use ECF\deleteComment;

include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

$pdo = new Mabdd();

if (isset($_POST['action']) && $_POST['action'] === 'deleteComment' && isset($_POST['commentId'])) {
    $deleteComment = new DeleteComment($pdo);
    $result = $deleteComment->execute($_POST['commentId']);
    if ($result) {
        $_SESSION['success_message'] = 'Commentaire supprimé avec succès.';
    } else {
        $_SESSION['error_message'] = 'Erreur lors de la suppression du commentaire.';
    }
    header('Location: edit.php?id=' . $_POST['articleId']); 
    exit;
}

if (isset($_GET['id'])) {


    $stmt = $pdo->prepare("SELECT * FROM posts WHERE ID = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, Article::class);
    $article = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM comments WHERE postId = :postId ORDER BY createdAt DESC");
    $stmt->execute(['postId' => $_GET['id']]);
    $commentaires = $stmt->fetchAll(PDO::FETCH_CLASS, Commentaire::class);

    
} else {
    header('Location: admin.php');
}

if (!empty($_POST) && isset($_POST['action'])) {
    $id = $_POST['id'];
    if ($_POST['action'] == 'update') {
        
        $title = $_POST['title'];
        $body = $_POST['body'];
        $stmt = $pdo->prepare("UPDATE posts SET title = :title, body = :body WHERE ID = :id");
        $stmt->execute(['title' => $title, 'body' => $body, 'id' => $id]);

       
        
        
    } elseif ($_POST['action'] == 'delete') {
       
        $stmt = $pdo->prepare("DELETE FROM posts WHERE ID = :id");
        $stmt->execute(['id' => $id]);

        header('Location: admin.php');
        exit;
    }
}

if (isset($_GET['id']) || isset($_POST['id'])) {

    $articleId = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE ID = :id");
    $stmt->execute(['id' => $articleId]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, Article::class);
    $article = $stmt->fetch();
}

dump($article);

?>

<h1>Editer un Article N° <?= htmlspecialchars($article->getId(), ENT_QUOTES, 'UTF-8') ?></h1>

<form action="#" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($article->getId(), ENT_QUOTES, 'UTF-8') ?>">

    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($article->getTitle(), ENT_QUOTES, 'UTF-8') ?>" required>
    </div>

    <div class="mb-3">
        <label for="body" class="form-label">Contenu</label>
        <textarea class="form-control" id="body" name="body" rows="5" required><?= htmlspecialchars($article->getBody(), ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <button type="submit" name="action" value="update" class="btn btn-primary">Mettre à jour</button>
    <button type="submit" name="action" value="delete" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de supprimer cet article ?');">Supprimer</button>
</form>
<h2>Commentaires</h2>
<div class="row">
    <?php foreach ($commentaires as $commentaire): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    Email : <strong><?= htmlspecialchars($commentaire->getEmail()) ?></strong>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($commentaire->getBody())) ?></p>
                </div>
                <div class="card-footer text-muted">
                    Posté le <?= htmlspecialchars($commentaire->getCreatedAt()) ?>

                    <form action="edit.php" method="POST" class="d-inline">
                        <input type="hidden" name="action" value="deleteComment">
                        <input type="hidden" name="commentId" value="<?= htmlspecialchars($commentaire->getId()) ?>">
                        <input type="hidden" name="articleId" value="<?= htmlspecialchars($article->getId()) ?>">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression de ce commentaire ?');">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


