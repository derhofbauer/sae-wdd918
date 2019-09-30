<article id="post-<?php echo $id; ?>" class="post">
    <header class="post__header">
        <h2>
            <a href="index.php?page=post&post_id=<?php echo $id; ?>">
                <?php echo $title; ?>
            </a>
        </h2>
    </header>
    <div class="post__meta">
        <span class="post__author"><?php echo $email; ?></span> -
        <span class="post__created"><?php echo $crdate; ?></span>
    </div>
    <div class="post__content">
        <?php echo $content; ?>
    </div>
</article>