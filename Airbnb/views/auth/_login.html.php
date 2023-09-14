<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <h1>Se connecter</h1>

    <?php if (isset($form_result) && $form_result->hasError()) : ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($form_result->getErrors() as $error) : ?>
                    <li><?php echo $error->getMessage(); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <form action="login" method="post">
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