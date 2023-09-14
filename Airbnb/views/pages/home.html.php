<div class="container text-center">
    <h1> <?php

            use App\Model\Bien;

            echo $list_title ?> </h1>


    <div class="row">
        <?php if (empty($bien_list)) {
            echo '<p>Aucun bien</p>';
        } else {
            echo '<ul class="list-inline">';
            foreach ($bien_list as $bien) {
                echo '<li class="list-inline-item me-4"><a href="#" class=" custom-link">' . $bien . '</a></li>';
            }
            echo '</ul>';
        } ?>
    </div>

    <?php
    // - S'il n'y a pas de biens
    if (empty($biens)) : ?>
        <p>Aucun bien en ce moment</p>
    <?php else : ?>
        <div class="d-flex flex-row flex-wrap justify-content-center col-6">
            <?php
            foreach ($biens as $bien) : ?>
                <div class="col-4">
                    <div class="card m-2" style="width: 18rem">
                        <img src="/img/photos_bien<?php echo $photo->$bien_id->image_path ?>" class="card-img-top img-fluid p-3" alt="<?php echo $bien->label ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $bien->label ?></h3>
                            <p class="card-text"><?php echo $bien->prix_nuitee ?> €</p>
                            <a href="/bien/<?php echo $bien->id ?>" class="btn btn-primary"> Voir détail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>