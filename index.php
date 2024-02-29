
<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
use ECF\Mabdd;
use ECF\Article;


$pdo = new Mabdd();
$articlesParPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $articlesParPage;


$totalArticles = $pdo->query("SELECT COUNT(id) FROM posts")->fetchColumn();
$totalPages = ceil($totalArticles / $articlesParPage);


$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY createdAt DESC LIMIT :start, :articlesParPage");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':articlesParPage', $articlesParPage, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_CLASS, Article::class);
?>

<div class="text-center mt-4">
    <h1>Mon blog</h1>
</div>


<div class="container mt-5">
    
    <div class="row">
        <?php foreach ($articles as $article): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $article->displayTitle() ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $article->displayCreatedAt() ?></h6>
                        <p class="card-text"><?= substr($article->displayBody(), 0, 100) ?>...</p>
                        <a href="post.php?id=<?= $article->getId() ?>" class="card-link">Lire la suite</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center my-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-primary mx-2">Précédent</a>
        <?php endif; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-primary mx-2">Suivant</a>
        <?php endif; ?>
    </div>
<div class="d-flex justify-content-center my-4">
    <a href="post.php" class="btn btn-success">Ajouter un article</a>
</div>

</div>


<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
?>
