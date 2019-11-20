<h2><?php echo $product->name; ?> <small><?php echo sprintf("(%01.2f ,-)", $product->price) ?></small></h2>

<?php
if (\App\Models\User::isLoggedin() && \Core\Libs\Session::get('is_admin')):
?>

    <a href="products/<?php echo $product->id; ?>/edit">Edit</a>

<?php endif; ?>

<div class="description">
    <?php echo $product->description; ?>
</div>

<div class="images">
    <?php foreach ($product->images as $image): ?>
        <img src="storage/<?php echo $image; ?>" alt="<?php echo $product->name; ?>" width="150">
    <?php endforeach; ?>
</div>

<a href="cart/add/<?php echo $product->id; ?>/1">Add To Cart</a>
