<?php

session_start();


include_once __DIR__ . '/template/header.php';
use ECF\Mabdd;


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$error = null;
$success = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $title = $_POST['title'];
    $body = $_POST['body'];
    $createdAt = date('Y-m-d H:i:s'); 
    $userId = $_SESSION['user']; 

    try {
        
        $pdo = new Mabdd();

        
        $stmt = $pdo->prepare("INSERT INTO posts (title, body, createdAt, userId) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $body, $createdAt, $userId]);

        
        $success = "Article ajouté avec succès.";
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = "Erreur lors de l'ajout de l'article : " . $e->getMessage();
    }
}

?>


<?php if ($error): ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success" role="alert"><?= $success ?></div>
<?php endif; ?>


<div class="container mt-4" >
    <h2>Ajouter un nouvel article</h2>
    <form method="POST" action="post.php">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="body">Contenu</label>
            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
        </div>
        <div class="d-flex justify-content-center my-4">

        <button type="submit" class="btn btn-primary">Publier</button>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/template/footer.php'; ?>
