<?php

require_once __DIR__ . '/../../../Models/Post.php';

use \Blog\Models\Post;

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<p>Zugriff verweigert</p>";
} else {
    $post_id = $_GET['post_id'];
    $post = Post::find($post_id, $link);

    if (isset($_POST['title'], $_POST['tags'], $_POST['content'])) { // Formular wurde abgeschickt
        $post->title = trim($_POST['title']);
        $post->content = trim($_POST['content']);

        $tags = explode(',', $_POST['tags']);
        $tags = array_map(function ($item) {
            return "%${item}%";
        }, $tags);
        $tags = implode('', $tags);
        $post->tags = $tags;

        $post->save($link);

        header("Location: index.php?page=post&post_id=$post->id");
    }

    ?>

    <form action="index.php?page=post-edit&post_id=<?php echo $_GET['post_id']; ?>" method="post">

        <label for="title">Title</label>
        <input type="text" name="title" value="<?php echo $post->title; ?>"> <br>

        <label for="tags">Tags</label>
        <input type="text" name="tags" value="<?php echo $post->getTags(); ?>"> <br>

        <label for="content">Content</label>
        <textarea name="content" cols="30" rows="10"><?php echo $post->content; ?></textarea> <br>

        <button type="submit">Speichern</button>
    </form>

    <?php
}
?>
