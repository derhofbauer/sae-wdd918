<h1>Links</h1>

<ul class="links">
    <?php
    /**
     * $links wird in der ./includes/redirect.php definiert
     */
    ?>
    <?php foreach ($links as $index => $url): ?>
        <li>
            <a href="index.php?page=links&url=<?php echo urlencode($url); ?>" target="_blank"><?php echo $index; ?></a><br>
            <a href="index.php?page=links&url=<?php echo urlencode($url); ?>&html_redirect=true" target="_blank"><?php echo $index; ?> (HTML redirect)</a>
            <?php if (array_key_exists($url, $_SESSION['links'])) {
                echo " - Wurde " . $_SESSION['links'][$url] . "x besucht";
            } ?>
        </li>
    <?php endforeach; ?>
</ul>
