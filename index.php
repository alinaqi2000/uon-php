<?php
include_once("./includes/includes.php");
$title = "Ed's Electronics";
include_once("./layout/header.php");
?>
<section></section>
<main>
	<h1>Welcome to Ed's Electronics</h1>

	<p>We stock a large variety of electrical goods including phones, tvs, computers and games. Everything comes with at least a one year guarantee and free next day delivery.</p>

	<hr />


	<?php $products = getAllProducts(10); ?>
	<h2>Product list</h2>
	<ul class="products">
		<?php if (!count($products)) : ?>
			<p>No product listed yet!</p>
		<?php endif; ?>
		<?php foreach ($products as $product) : ?>
			<li>
				<a href="product_details.php?product=<?= $product['product_id'] ?>">
					<h3><?= $product['name'] ?></h3>
					<p><?= $product['description'] ?></p>
					<p><strong>Manufacturer:</strong>  <?= $product['manufacturer'] ?></p>
					<p>
						<?= nl2br($product['detail']) ?>
					</p>

					<div class="price">£<?= $product['price'] ?></div>


				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</main>
<?php
include_once("./layout/footer.php");
