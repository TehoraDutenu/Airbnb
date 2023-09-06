<h1> <?php echo $h1_tag ?> </h1>

<a href="/admin/addUser" class="btn btn-warning">Ajouter un utilisateur</a>

<?php if (empty($users)) : ?>
    <div>Aucun utilisateur enregistré</div>
<?php else : ?>

    <div class="d-flex flex-row flex-wrap justify-content-center col-6">
        <?php foreach ($users as $user) :
            $role = $user->role == 1 ? 'Utilisateur' : 'Administrateur'; ?>
            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $user->email ?> </h5>
                    <p class="card-text"> <?php echo $role ?> </p>
                    <a href="admin/update/<?php echo $user->id ?>" class="btn btn-success">Modifier</a>
                    <a href="/admin/delete/<?php echo $user->id ?>" class="btn btn-danger">Supprimer</a>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>