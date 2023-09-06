<div class="col-4 d-flex flex-column border p-3">
    <h1> <?php echo $h1_tag ?> </h1>
    <?php if ($form_result && $form_result->hasError()) : ?>

        <div>
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif; ?>


    <form action="/createToy" method="post" enctype="multipart/form-data">
        <!-- Input name -->
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control">
        </div>

        <!-- Input description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description du jouet</label>
            <textarea name="description" rows="5" cols="48"></textarea>
        </div>

        <!-- Input price -->
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" name="price" class="form-control">
        </div>

        <!-- Input marques -->
        <div class="mb-3">
            <label for="brand_id" class="form-label">Marque</label>
            <select name="brand_id" class="form-select">
                <?php

                foreach ($marques as $brand) :  ?>
                    <option value="<?php echo $brand->id ?>"> <?php echo $brand->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input pour l'image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image du jouet</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>