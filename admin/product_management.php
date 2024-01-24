<?php
$title = "Products Management";
include_once("./layout/header.php");

if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];

    $conn->query("DELETE FROM product_categories WHERE product_id='$product_id'");
    $conn->query("DELETE FROM products WHERE product_id='$product_id'");

    setFlashSuccess("Product deleted successfully!");
    redirect("product_management.php");
}
$products = getAllProducts();
?>
<div class="container mt-4">
    <h2>Product Management</h2>

    <div class="row">
        <div class="col-md-12">
            <a href="add_product.php" class="btn btn-success">Add Product</a>
        </div>
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Products List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th>Manufacturer</th>
                        <th>Price</th>
                        <th width="15%">Added By</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!count($products)) : ?>
                        <tr>
                            <td colspan="3" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['manufacturer']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['full_name']; ?></td>
                            <td>
                                <a href="add_product.php?edit_product=<?= $product['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_product=<?= $product['product_id'] ?>" onclick="return confirm('Are you sure, you want to delete this product?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    const table = $('table').dataTable();
</script>
<?php include_once("./layout/footer.php"); ?>