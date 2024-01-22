<?php
$title = "Products Management";
include_once("./layout/header.php");

if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $sql = "DELETE FROM products WHERE id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        setFlashSuccess("Product added successfully!");
        redirect("product_management.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$products = fetchRowsFromTable("products");
?>
<div class="container mt-4">
    <h2>Product Management</h2>

    <div class="row">
        <div class="col-md-12">
            <a href="add_product.php" class="btn btn-primary">Add Product</a>
        </div>
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>

    <!-- Display Existing Products -->
    <div class="card mt-4">
        <div class="card-header">
            Existing Products
        </div>
        <div class="card-body">
            <!-- Display a table with existing products -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Manufacturer</th>
                        <th>Price</th>
                        <th width="20%">Actions</th>
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
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['description']; ?></td>
                            <td><?php echo $product['manufacturer']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td>
                                <a href="add_product.php?edit_product=<?= $product['product_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_product=<?= $product['product_id'] ?>" onclick="return confirm('Are you sure, you want to delete this product?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php include_once("./layout/footer.php"); ?>