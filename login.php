<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

use ECF\Mabdd;
use ECF\User;

$error = null;
$success = null;

if (isset($_SESSION['user'])) {
    $success = "Vous êtes déjà connecté.";
    header('Location: index.php'); 
    exit;
}

if (!empty($_POST)) {
    if (!isset($_POST['identifier']) || $_POST['identifier'] === "") {
        $error = "Veuillez entrer votre nom d'utilisateur ou votre adresse e-mail.";
    } elseif (!isset($_POST['password']) || $_POST['password'] === "") {
        $error = "Veuillez entrer votre mot de passe.";
    } else {
        try {
            $pdo = new Mabdd();
            $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :identifier OR email = :identifier");
            $stmt->bindParam(':identifier', $_POST['identifier'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
            $user = $stmt->fetch();

            if ($user && $user->verifMDP($_POST['password'])) {
                $_SESSION['user'] = $user->getId(); 
                $_SESSION['role'] = $user->getRole(); 

                $success = "Vous êtes connecté.";
                
                header('Location: ' . ($_SESSION['role'] === 'admin' ? 'admin.php' : 'index.php'));
                exit;
            } else {
                $error = "Le login, l'email ou le mot de passe est incorrect.";
            }
        } catch (\PDOException $e) {
            $error = "Erreur de connexion : " . $e->getMessage();
        }
    }
}
?>

<?php if ($error) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php if (!$success) : ?>
    <div class="row mt-4">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1>Se connecter</h1>
            <form method="POST" action="#">
                <div class="mb-3">
                    <label for="inputIdentifier" class="form-label">Login ou email</label>
                    <input type="text" class="form-control" name="identifier" id="inputIdentifier" placeholder="login/email">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Se Connecter</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
<?php endif; ?>

<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
?>
