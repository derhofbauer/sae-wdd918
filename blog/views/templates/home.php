<?php

/**
 * Blog posts auflisten
 */
$result = mysqli_query($link, "SELECT posts.*, users.email FROM posts JOIN users ON posts.user_id = users.id");

while ($row = mysqli_fetch_assoc($result)) {
    extract($row); // generiert aus einem Array einzelne Variablen
    require __DIR__. "/../partials/post.php";
}
