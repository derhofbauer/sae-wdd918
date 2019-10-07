<?php

/** Liste aller Posts in einer Kategorie */

if (!isset($_GET['category_id'])) {
    require_once __DIR__ . '/../partials/404.php';
} else {
    $categoryId = $_GET['category_id'];

    // Posts einer Kategorie abfragen
    $result_posts = mysqli_query($link, "SELECT posts.*, users.email FROM posts JOIN categories_posts_mm ON posts.id = categories_posts_mm.post_id JOIN users ON users.id = posts.user_id WHERE categories_posts_mm.category_id = $categoryId");

    // einzelne Kategorie abfragen
    $result_category = mysqli_query($link, "SELECT * FROM categories WHERE id = $categoryId");
    $category = mysqli_fetch_assoc($result_category); // es kann aus dem obigen Query nur max. 1 Datensatz zurück kommen, wir brauchen also keine while-Schleife

    $category_title = $category['title'];
    echo "<h2>Kategorie: $category_title</h2>";

    while ($row = mysqli_fetch_assoc($result_posts)) {
        extract($row);
        require __DIR__. "/../partials/post.php";
    }
}
