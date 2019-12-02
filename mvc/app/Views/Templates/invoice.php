<h2>Invoice <small>Nr. <?php echo $invoice->order_id; ?></small></h2>

<h3>Status: <?php echo $invoice->status; ?></h3>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Quantity</th>
        <th>Product Name</th>
        <th>Total price</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($invoice->products as $product): ?>
        <tr>
            <td><?php echo $product->id; ?></td>
            <td><?php echo $product->quantity; ?></td>
            <td><?php echo $product->name; ?></td>
            <td><?php echo \App\Models\Product::formatPrice($product->totalPriceOfUnit); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td>Total price:</td>
        <td><?php echo \App\Models\Product::formatPrice($invoice->totalPrice); ?></td>
    </tr>
    </tfoot>
</table>

<h2>Lieferadresse</h2>
<p><strong><?php echo $invoice->user->username; ?></strong></p>
<p><?php echo $invoice->address->address; ?></p>
