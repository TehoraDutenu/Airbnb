<h2> <?php echo $list_title ?> </h2>
<?php if (empty($toy_list)) {
    echo '<p>Aucun jouet</p>';
} else {
    echo '<ul>';
    foreach ($toy_list as $toy) {
        echo '<li>' . $toy . '</li>';
    }
    echo '</ul>';
} ?>