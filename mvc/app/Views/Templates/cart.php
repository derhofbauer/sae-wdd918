<ul>
    <?php foreach ($products as $product): ?>
    <li><?php echo $product->quantity; ?>x <?php echo $product->name; ?> - <a href="cart/update/<?php echo $product->id; ?>/0">Remove from cart</a> -
        <a href="cart/update/<?php echo $product->id; ?>/<?php echo $product->quantity - 1; ?>">minus 1</a> -
        <a href="cart/update/<?php echo $product->id; ?>/<?php echo $product->quantity + 1; ?>">plus 1</a></li>
    <?php endforeach; ?>
</ul>
