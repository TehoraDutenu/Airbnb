<div class="col-4 d-flex flex-column border p-3">
    <h1> <?php echo $h1_tag ?> </h1>
    <?php if ($form_result && $form_result->hasError()) : ?>

        <div>
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif; ?>


    <form action="/add" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="d-flex flex-column mb-3">
            <div>
                <label for="role" class="form-label">Son role</label>
            </div>
            <div>
                <input type="radio" name="role" value="1" checked>
                <label for="role">Utilisateur</label>
            </div>
            <div>
                <input type="radio" name="role" value="2">
                <label for="role">Administrateur</label>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>