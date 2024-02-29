<?php
session_start();

include_once __DIR__ . '/template/header.php';
use ECF\Mabdd;
use ECF\Article;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $articleId = $_GET['id'];

    $pdo = new Mabdd();
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $articleId]);
    $article = $stmt->fetchObject(Article::class);

    if ($article) {
        ?>
          <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article->displayTitle() ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $article->displayCreatedAt() ?></h6>
                            <p class="card-text"><?= nl2br($article->displayBody()) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='container mt-4'><p>Article non trouvé.</p></div>";
    }
} else {
    header('Location: index.php');
    exit;
}

include_once __DIR__ . '/template/footer.php';
?>
