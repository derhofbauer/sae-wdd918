<h2><?php echo $welcome_message; ?></h2>

<h3>Products</h3>

<ul>
    <?php foreach ($products as $product): ?>
        <li>
            <a href="products/<?php echo $product->id; ?>"><?php echo $product->name; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
