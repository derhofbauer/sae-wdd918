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
    <?php foreach ($products as $product): ?>
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
        <td><?php echo \App\Models\Product::formatPrice($totalPrice); ?></td>
    </tr>
    </tfoot>
</table>

<div class="proceed">
    <a href="checkout/address">Add delivery address</a>
</div>
