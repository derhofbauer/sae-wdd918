<h2><?php echo $welcome_message; ?></h2>

<h3>Products</h3>

<ul>
    <?php foreach ($products as $product): ?>
        <li><?php echo $product->name; ?></li>
    <?php endforeach; ?>
</ul>
