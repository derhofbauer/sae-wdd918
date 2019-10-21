<article id="post-<?php echo $id; ?>" class="post">
    <header class="post__header">
        <h2><?php echo $title; ?></h2>
    </header>
    <div class="post__meta">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="index.php?page=post-edit&post_id=<?php echo $id; ?>">Edit</a> -
        <?php endif; ?>
        <span class="post__author"><?php echo $email; ?></span> -
        <span class="post__created"><?php echo $crdate; ?></span> -
        <span class="post__categories">
            <?php foreach ($categories as $category): ?>
                <a href="index.php?page=category&category_id=<?php echo $category['category_id']; ?>">
                    <?php echo $category['category_title']; ?>
                </a>
            <?php endforeach; ?>
        </span>
    </div>
    <div class="post__content">
        <?php echo $content; ?>
    </div>
</article>
