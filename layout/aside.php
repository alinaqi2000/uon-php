<?php $featured_products = getFeaturedProducts(10); ?>
<aside>
	<h1><a href="#">Featured Product</a></h1>
	<?php if (!count($featured_products)) : ?>
		<p>No product featured!</p>
	<?php endif; ?>
	<?php foreach ($featured_products as $product) : ?>
		<a href="product_details.php?product=<?= $product['product_id'] ?>">
			<p><strong><?= $product['name'] ?></strong></p>
			<p><?= $product['description'] ?></p>
		</a>
	<?php endforeach; ?>
</aside>