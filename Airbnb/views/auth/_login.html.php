<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body style="background-color: beige;">
    <h1 style="text-align: center; color:#f5796c; margin-top:100px;">Se connecter</h1>

    <?php if (isset($form_result) && $form_result->hasError()) : ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($form_result->getErrors() as $error) : ?>
                    <li><?php echo $error->getMessage(); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="login" method="post" style="width: 300px; height: 300px; border: 2px solid #f5796c; margin-left:auto; margin-right:auto; margin-top:50px; background-color:#fdfdf7; padding: 15px;">
        <div class="inputs">
            <label for="email">
                Email : <input type="email" name="email" id="email">
            </label><br>
            <label for="password">
                Mot de passe : <input type="password" name="password" id="password">
            </label><br>
            <input class="form-button" type="submit" value="Connexion">
        </div>
    </form>
</body>

</html>