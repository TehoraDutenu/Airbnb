<div class="d-flex flex-row flex-wrap justify-content-center col-6">
    <?php

    use Core\Repository\AppRepoManager;

    foreach ($biens as $bien) : ?>
        <div class="col-4">
            <div class="card m-2" style="width: 18rem">
                <?php $couv = AppRepoManager::getRm()->getPhotoRepo()->getPhotoByBienId($bien->id); ?>
                <!-- TODO: faire une boucle avec une incrémentation (i) pour boucler sur toutes mes photos -->
                <img src="/img/photosbien/<?php echo $couv[0]->image_path ?>" class="card-img-top img-fluid p-3" alt="<?php echo $bien->label ?>">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $bien->label ?></h3>
                    <p class="card-text"><?php echo $bien->description ?></p>
                    <?php echo '<ul class="list-inline">';
                    foreach ($equipements as $equipement) {
                        echo '<li class="list-inline-item me-4"><a href="#" class=" custom-link">' . $equipement . '</a></li>';
                    }
                    echo '</ul>'; ?>

                    <p class="card-text"><?php echo $bien->prix_nuitee ?> €</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>