<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if ($auth::isAuth()) $auth::redirect('/') ?>

    <h2>Connexion</h2>

    <?php
    // - Afficher les erreurs s'il y en a
    if ($form_result && $form_result->hasError()) {
    ?>
        <div>
            <?php echo $form_result->getErrors()[0]->getMessage(); ?>
        </div>
    <?php
    }
    ?>
    <form action="/login" method="post">
        <label for="email">
            Email : <input type="email" name="email" id="email">
        </label><br>
        <label for="password">
            Mot de passe : <input type="password" name="password" id="password">
        </label><br>
        <input type="submit" value="GO !">
    </form>
</body>


</html>