<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php if ($auth::isAuth()) $auth::redirect('/'); ?>

    <h1>Se connecter</h1>

    <!-- Afficher les erreurs éventuelles -->
    <?php
    if ($form_result && $form_result->hasError()) {
    ?>
        <div>
            <?php echo $form_result->getErrors()[0]->getMessage(); ?>
        </div>
    <?php
    }
    ?>

    <!-- Formulaire de connexion -->
    <form action="/login" method="post">
        <label for="email">
            Email : <input type="email" name="email" id="email">
        </label><br>
        <label for="password">
            Mot de passe : <input type="password" name="password" id="password">
        </label><br>
        <input type="submit" value="Connexion">
    </form>
</body>

</html>