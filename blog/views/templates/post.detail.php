<?php

/**
 * Einzelansicht eines Blog Posts
 */

if (!isset($_GET['post_id'])) {
    require_once __DIR__ . '/../partials/404.php';
} else {
    // post aus der datenbank abfragen
    $postId = $_GET['post_id'];

    $result = mysqli_query($link, "SELECT posts.*, users.email FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = $postId");

    while ($row = mysqli_fetch_assoc($result)) {
        /**
         * Die extract Funktion macht im Hintergrund folgendes:
         *
         * $id = $row['id'];
         * $title = $row['title'];
         * usw.
         */
        extract($row);

        // categories abfragen
        $categories_result = mysqli_query($link, "SELECT categories.id AS category_id , categories.title AS category_title FROM categories JOIN categories_posts_mm ON categories.id = categories_posts_mm.category_id WHERE categories_posts_mm.post_id = $id");

        $categories = [];
        while ($row = mysqli_fetch_assoc($categories_result)) {
            $categories[] = $row;
        }

        // post ausgeben
        require __DIR__ . '/../partials/post.single.php';
    }
}
