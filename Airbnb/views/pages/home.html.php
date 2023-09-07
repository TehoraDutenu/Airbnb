    <h1> <?php echo $list_title ?> </h1>
    <?php if (empty($bien_list)) {
        echo '<p>aucun bien</p>';
    } else {
        echo '<ul>';
        foreach ($bien_list as $bien) {
            echo '<li>' . $bien . '</li>';
        }
        echo '</ul>';
    } ?>