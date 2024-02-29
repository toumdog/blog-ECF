<?php

use ECF\Mabdd;
use ECF\Article;

include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

$pdo = new Mabdd();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== "admin") {
    header('Location: index.php');
    exit; 
}

$articlesParPage = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $articlesParPage; 

$totalArticles = $pdo->query("SELECT COUNT(ID) FROM posts")->fetchColumn();
$pagesTotal = ceil($totalArticles / $articlesParPage); 

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY ID DESC LIMIT :start, :articlesParPage");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':articlesParPage', $articlesParPage, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_CLASS, Article::class);

?>

<h1>Administration</h1>
<h3>Gestion des articles</h3>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Title</th>
                    <th>Text</th>
                    <th>Date Creation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?= htmlspecialchars($article->getId()); ?></td>
                        <td><?= htmlspecialchars($article->getTitle()); ?></td>
                        <td><?= htmlspecialchars($article->getBody()); ?></td>
                        <td><?= htmlspecialchars($article->getCreatedAt()); ?></td>
                        <td><a href="edit.php?id=<?= htmlspecialchars($article->getId()) ?>" class="btn btn-success">Modifier</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $pagesTotal; $i++): ?>
            <li class="page-item <?= ($page === $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
?>
