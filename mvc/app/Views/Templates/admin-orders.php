<h2>Admin: Orders</h2>

<ul>
    <?php foreach ($orders as $order): ?>
        <li>
            <a href="admin/orders/<?php echo $order->id; ?>">
                <strong>#<?php echo $order->id; ?></strong>: <?php echo $order->crdate; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
