<div class="col-4 d-flex flex-column border p-3">
    <h1>Modifier l'utilisateur</h1>
    <?php if ($form_result && $form_result->hasError()) : ?>

        <div>
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif; ?>


    <form action="/update" method="post">
        <div class="mb-3">
            <input type="hidden" value="<?php echo $user->id ?>" name="id">

            <label for="email" class="form-label">Email</label>
            <input type="email" value="<?php echo $user->email ?>" name="email" class="form-control">
        </div>

        <div class="d-flex flex-column mb-3">
            <div>
                <label for="role" class="form-label">Son role</label>
            </div>
            <div>
                <input type="radio" name="role" value=1 <?php echo $user->role == 1 ? 'checked' : '' ?>>
                <label for="role">Utilisateur</label>
            </div>
            <div>
                <input type="radio" name="role" value=2 <?php echo $user->role == 2 ? 'checked' : '' ?>>
                <label for="role">Administrateur</label>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>