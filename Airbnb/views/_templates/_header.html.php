<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title_tag ?> </title>
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CDN Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Mon style -->
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <?php

    use Core\Session\Session; ?>


    <div id="container">
        <header>
            <?php if (Session::has(Session::SUCCESS_MESSAGE)) : ?>
                <div class="alert alert-success">
                    <?php echo Session::get(Session::SUCCESS_MESSAGE); ?>
                </div>
                <?php Session::remove(Session::SUCCESS_MESSAGE); // Supprimer le message après l'avoir affiché 
                ?>
            <?php endif; ?>
            <?php if (Session::has(Session::LOGOUT_SUCCESS_MESSAGE)) : ?>
                <div class="alert alert-success">
                    <?php echo Session::get(Session::LOGOUT_SUCCESS_MESSAGE); ?>
                </div>
                <?php Session::remove(Session::LOGOUT_SUCCESS_MESSAGE); // Supprimer le message après l'avoir affiché 
                ?>
            <?php endif; ?>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <!-- Logo -->
                <a class="navbar-brand" href="/"><img src="/img/logo.svg.png" alt="Logo du site" class="logo"></a>

                <div class="d-flex align-items-center ml-auto">

                    <!-- Boutons Incription et Connexion -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php
                            if (!$auth::isAuth()) { ?>
                                <a class="nav-link custom-link" href="/inscription">Inscription</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <?php
                        if (!$auth::isAuth()) { ?>
                            <a class="nav-link  custom-link" href="/connexion">Connexion</a>
                    </li>
                <?php } ?>

                <!-- Bouton proposer un bien -->
                <li class="nav-item">
                    <?php if ($auth::isAuth()) { ?>
                        <a href="/proposer" class="nav-link  custom-link">Proposer un bien</a>
                    <?php
                    } ?>
                </li>

                <!-- Icone de logout -->
                <li class="nav-item">
                    <?php if ($auth::isAuth()) { ?>
                        <a class="nav-link custom-link" href="/logout" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Déconnexion">
                            <i class="bi bi-box-arrow-left"></i>
                        </a>
                    <?php
                    } ?>

                </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>