<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo isset($title_tag) ? $title_tag : "Mon super site" ?></title>

    <?php

    use Core\Repository\AppRepoManager;  ?>


    <!-- CDN Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <!-- CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Notre style  -->
    <link rel="stylesheet" href="/style.css">
</head>

<body>

    <?php if (!$auth::isAuth()) $auth::redirect('/connexion') ?>

    <div id="container">

        <header>
            <div class="logo">
                <a href="/">
                    <img src="/img/logo.jpg" alt="Logo du site">
                </a>
            </div>
        </header>

        <div id="top-bar">
            <nav id="nav-menu" class="menu-hidden">
                <ul class="menu-root">

                    <!-- Affichage du menu réservé à l'administrateur -->
                    <?php
                    if ($auth::isAdmin()) : ?>
                        <li>
                            <a href="#">Accès Admin <i class="bi bi-chevron-down"></i> </a>
                            <ul>
                                <li><a href="/admin/users">Gérer les utilisateurs</a></li>
                                <li><a href="/admin/addToy">Gérer les jeux</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li><a href="/">Tous les jouets</a></li>
                    <li>
                        <a href="#">Par marque <i class="bi bi-chevron-down"></i> </a>
                        <ul>
                            <?php
                            foreach (AppRepoManager::getRm()->getBrandRepo()->getBrandByName() as $brands) : ?>

                                <li>
                                    <a href="/brands/<?php echo $brands->id ?>"> <?php echo $brands->name ?> ( <?php echo $brands->nb_toys ?> ) </a>
                                </li>

                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="d-flex align-items-center m-2">
                <li>
                    <a href="/logout" class="logout">
                        <i class="bi bi-box-arrow-left"></i>
                    </a>
                </li>
            </div>
        </div>