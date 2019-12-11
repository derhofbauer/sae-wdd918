<div class="row">
    <div class="col-6">
        <?php echo $form; ?>
    </div>
    <div class="col-6">
        <ul>
            <?php foreach ($order->products as $product): ?>
                <li><?php echo $product->quantity; ?>x <?php echo $product->name; ?> -
                    <a href="admin/orders/<?php echo $order->id; ?>/set/<?php echo $product->id; ?>/0">Remove from order</a> -
                    <a href="admin/orders/<?php echo $order->id; ?>/set/<?php echo $product->id; ?>/<?php echo $product->quantity - 1; ?>">minus 1</a>
                                                     -
                    <a href="admin/orders/<?php echo $order->id; ?>/set/<?php echo $product->id; ?>/<?php echo $product->quantity + 1; ?>">plus 1</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
