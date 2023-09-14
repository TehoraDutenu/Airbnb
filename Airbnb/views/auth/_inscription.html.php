<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h1>Créer un compte</h1>


    <form action="register" method="post">
        <label for="prenom">
            Prénom : <input type="text" name="prenom" id="prenom" required>
        </label><br>
        <label for="nom">
            Nom : <input type="text" name="nom" id="nom" required>
        </label><br>
        <label for="email">
            Email : <input type="email" name="email" id="email" required>
        </label><br>
        <label for="telephone">
            Telephone : <input type="text" name="telephone" id="telephone" required>
        </label><br>
        <label for="adresse">
            Adresse : <input type="text" name="adresse" id="adresse" required>
        </label><br>
        <label for="password">
            Mot de passe : <input type="password" name="password" id="password" required>
        </label><br>
        <label for="password">
            Confirmer mot de passe : <input type="password" name="verif-password" id="verif-password" required>
        </label><br>

        <input type="submit" value="Inscription" class="connect-button">
    </form>
</body>

</html>