<div class="col-4 d-flex flex-column border p-3">
    <h1> <?php echo $h1_tag ?> </h1>
    <?php if ($form_result && $form_result->hasError()) : ?>

        <div>
            <?php echo $form_result->getErrors()[0]->getMessage() ?>
        </div>
    <?php endif; ?>


    <form action="/updateToy" method="post" enctype="multipart/form-data">
        <!-- Input hidden pour l'id du jouet -->
        <input type="hidden" name="id" value="<?php echo $toy->id ?>">
        <!-- Input name -->
        <div class="mb-3">
            <label for="name" class="form-label">Titre du jouet</label>
            <input type="text" name="name" value="<?php echo $toy->name ?>" class="form-control">
        </div>

        <!-- Input description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description du jouet</label>
            <textarea name="description" rows="5" cols="48"><?php echo $toy->description ?></textarea>
        </div>

        <!-- Input price -->
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" value="<?php echo $toy->price ?>" name="price" class="form-control">
        </div>

        <!-- Input marques -->
        <div class="mb-3">
            <label for="brand_id" class="form-label">Marque</label>
            <select name="brand_id" class="form-select">
                <?php foreach ($marques as $brand) : ?>
                    <option value="<?php echo $brand->id ?>" <?php echo $brand->id == $toy->brand_id ? 'selected' : '' ?>> <?php echo $brand->name ?></option>
                    <option value="<?php echo $brand->id ?>"> <?php echo $brand->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input pour l'image -->
        <div class="mb-3 d-flex">
            <div>
                <label for="image" class="form-label">Image du jouet</label>
                <input type="file" value="<?php echo $toy->image ?>" name="image" class="form-control">
            </div>
            <div><img src="/img/<?php echo $toy->image ?>" alt="<?php echo $toy->name ?>" width="100"></div>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>