<div class="d-flex flex-row flex-wrap justify-content-center col-6 m-3">
    <h1> <?php echo $title_tag ?> </h1>
    <div class="d-flex mt-3">
        <div class="col-4">
            <img src="/img/<?php echo $toy->image ?>" alt="<?php echo $toy->name ?>">
            <!-- Ajouter la marque du jouet -->
            <h4> <?php echo $toy->brands->name ?> </h4>
        </div>
        <div class="col-8">
            <p> <?php echo $toy->description ?> </p>
        </div>
    </div>
</div>