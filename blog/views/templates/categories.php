<?php

$result = mysqli_query($link, "SELECT * FROM categories");

?>

<h1>Kategorien</h1>
<ul>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        extract($row);
        echo "<li><a href=\"index.php?page=category&category_id=$id\">$title</a></li>";
    }
    ?>
</ul>
