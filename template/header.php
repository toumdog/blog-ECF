<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
   
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Mon blog</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mon blog Voyage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Acceuil</a>
                    </li>
                    <?php if(!isset($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php else : ?> 
                        <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li> 
                    <?php endif ?>   
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Administrateur</a>
                    </li> 
                    <?php endif ?> 

                </ul>

            </div>
        </div>
    </nav>
    <main class="container">