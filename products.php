<?php
include_once("./includes/includes.php");
$category_id = $_GET['category'];
$categories = fetchRowsFromTable("categories", "*", "category_id=:0", [$category_id]);
if (!$categories[0]) {
    redirect("index.php");
}

$category = $categories[0];
$title = $category['category_name'] . " - Products";

include_once("./layout/header.php");
?>
<section></section>
<main>

    <?php $products = getCategoryProducts($category_id); ?>
    <h2><?= $category['category_name'] ?> - Product list</h2>
    <ul class="products">
        <?php if (!count($products)) : ?>
            <p>No product listed yet!</p>
        <?php endif; ?>
        <?php foreach ($products as $product) : ?>
            <li>
                <a href="product_details.php?product=<?= $product['product_id'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <p><strong>Manufacturer:</strong> <?= $product['manufacturer'] ?></p>
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
