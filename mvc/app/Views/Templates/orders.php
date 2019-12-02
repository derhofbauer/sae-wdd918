<h2>Orders</h2>

<ul>
    <?php foreach ($invoices as $invoice): ?>
        <li>
            <a href="account/invoice/<?php echo $invoice->order_id; ?>"><?php echo $invoice->order_id; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
