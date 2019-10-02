<article id="post-<?php echo $id; ?>" class="post">
    <header class="post__header">
        <h2><?php echo $title; ?></h2>
    </header>
    <div class="post__meta">
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
