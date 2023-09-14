<h1><?php echo $h1_tag ?></h1>
<?php
// - S'il n'y a pas de biens
if (empty($biens)) : ?>
    <p>Aucun bien en ce moment</p>
<?php else : ?>
    <div class="d-flex flex-row flex-wrap justify-content-center col-6">
        <?php
        foreach ($biens as $bien) : ?>
            <div class="card m-2" style="width: 18rem">
                <img src="/img/photos_bien <?php echo $photo->image_path ?>" class="card-img-top img-fluid p-3" alt="<?php echo $bien->label ?>">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $bien->label ?></h3>
                    <p class="card-text"><?php echo $bien->prix_nuitee ?> €</p>
                    <a href="/bien/<?php echo $bien->id ?>" class="btn btn-primary"> Voir détail</a>
                    <!-- Ajouter des boutons Modifier / Supprimer -->
                    <!-- <a href="/#/<?php // echo $bien->id 
                                        ?>" class="btn btn-warning">Modifier</a> -->
                    <!-- <a href="/#/<?php // echo $bien->id 
                                        ?>" class="btn btn-danger">Supprimer</a> -->

                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>