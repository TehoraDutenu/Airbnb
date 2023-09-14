<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer</title>
</head>

<body>
    <h1>Proposer un bien</h1>

    <?php if ($form_result && $form_result->hasError()) : ?>
        <div>
            <?= $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif; ?>


    <form action="createBien" method="post">

        <?php if ($bien && $bien->utilisateur) : ?>
            <input type="hidden" value="<?php echo $bien->utilisateur ?>" name="utilisateur">
        <?php endif; ?>

        <fieldset>
            <legend>Quel type de bien proposez vous ?</legend>
            <div>
                <select name="typebien" id="typebien">
                    <?php foreach ($typebien as $typeDeBien) : ?>
                        <option value="<?php echo $typeDeBien ?>" <?php if ($typebien === $typeDeBien) echo 'selected'; ?>><?php echo $typeDeBien ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset><br>

        <fieldset>
            <label for="label">
                Donnez un titre à votre location : <input type="text" name="label" id="label" required><br>
            </label>
            <label for="label">Décrivez-nous votre bien :
                <textarea id="description" name="description" rows="5" cols="33">Description...</textarea>
            </label><br>
            <label for="adresse">
                Quelle est l'adresse de votre bien (ne sera transmise au locataire que le jour d'arrivée) : <input type="text" name="adresse" id="adresse" required><br>
            </label>
        </fieldset><br>

        <fieldset>
            <label for="taille">
                Quelle est la surface de votre bien (en m²) : <input type="number" name="taille" id="taille" required>
            </label><br>
            <label for="nbr_pieces">
                Combien de pièces comprend votre bien : <input type="number" name="nbr_pieces" id="nbr_pieces" required>
            </label><br>
            <label for="nbre_couchages">
                Combien de couchages comprend votre bien : <input type="number" name="nbre_couchages" id="nbre_couchages" required>
            </label><br>
        </fieldset><br>

        <fieldset>
            <legend>Équipements</legend>
            <?php foreach ($equipements as $equipement) : ?>
                <div>
                    <input type="checkbox" name="equipements[]" value="<?php echo $equipement->id ?>">
                    <label for="equipement"><?php echo $equipement->label ?></label>
                </div>
            <?php endforeach; ?>
        </fieldset><br>

        <fieldset>
            <legend>Paramétrez les disponibilités de votre bien</legend>
            <label for="start">Date début :</label>
            <input type="date" id="start" name="start" value="2023-09-01" min="2023-09-01" max="2030-12-31" />

            <label for="start">Date fin :</label>
            <input type="date" id="end" name="end" value="2023-09-01" min="2023-09-01" max="2030-12-31" />

            <input type="submit" value="Valider">
            <input type="submit" value="Ajouter une autre plage">
        </fieldset>

        <fieldset>
            <legend>Acceptez vous les animaux de compagnie ?</legend>
            <div>
                <input type="radio" name="are_animals" value="1" checked>
                <label for="role">Oui</label>
            </div>
            <div>
                <input type="radio" name="are_animals" value="2">
                <label for="role">Non</label>
            </div>
        </fieldset><br>

        <fieldset>
            <legend>Postez des photos de votre bien</legend>
            <input type="file" name="photo[]" accept="photo/*" multiple />
        </fieldset><br>

        <fieldset>
            <label for="prix_nuitee">Quel prix demandez vous pour une nuitée ?</label>
            <input type="number" name="prix_nuitee" id="prix_nuitee">
        </fieldset><br>

        <input type="submit" value="Enregistrer" class="connect-button">
    </form>
</body>

</html>