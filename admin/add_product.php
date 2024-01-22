<?php
$product_id = $_GET['edit_product'];
$title = empty($product_id) ? 'Add Product' : 'Update Product';
include_once("./layout/header.php");


$product_name = $product_description = $product_manufacturer = $product_price = $product_category = '';

if (isset($_GET['edit_product'])) {
    // Fetch existing product details from the database
    // Example: Implement your logic to fetch product details based on $product_id
    $sql = "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();

        // Set form variables with existing product details
        $product_name = $product['name'];
        $product_description = $product['description'];
        $product_manufacturer = $product['manufacturer'];
        $product_price = $product['price'];
        $product_category = $product['category_id'];
    }
}

// Handle form submissions for adding/editing products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_manufacturer = $_POST['product_manufacturer'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    // Check if the form is in "Add Product" mode
    if (empty($_POST['product_id'])) {
        // Add Product Logic
        $sql = "INSERT INTO products (name, description, manufacturer, price, category_id) VALUES ('$product_name', '$product_description', '$product_manufacturer', '$product_price', '$product_category')";

        if ($conn->query($sql) === TRUE) {
            setFlashSuccess("Product added successfully!");
            redirect("product_management.php");
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Update Product Logic
        $product_id = $_POST['product_id'];
        $sql = "UPDATE products SET name='$product_name', description='$product_description', manufacturer='$product_manufacturer', price='$product_price', category_id='$product_category' WHERE id='$product_id'";

        if ($conn->query($sql) === TRUE) {
            setFlashSuccess("Product updated successfully!");
            redirect("product_management.php");
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<div class="container mt-4">
    <h2>
        <?php echo $title ?>
    </h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required>
        </div>

        <div class="form-group">
            <label for="product_description">Product Description:</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="4"><?php echo $product_description; ?></textarea>
        </div>

        <div class="form-group">
            <label for="product_manufacturer">Manufacturer:</label>
            <input type="text" class="form-control" id="product_manufacturer" name="product_manufacturer" value="<?php echo $product_manufacturer; ?>" required>
        </div>

        <div class="form-group">
            <label for="product_price">Price:</label>
            <input type="number" class="form-control" id="product_price" name="product_price" value="<?php echo $product_price; ?>" required>
        </div>

        <div class="form-group">
            <label for="product_category">Category:</label>
            <select class="form-control" id="product_category" name="product_category" required>
                <!-- Populate the dropdown with categories from your database -->
                <?php
                // Example: Fetch categories from the database
                $categories = array(); // Replace with actual data from the database

                foreach ($categories as $category) {
                    $selected = ($category['id'] == $product_category) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="<?php echo empty($product_id) ? 'add_product' : 'update_product'; ?>">
            <?php echo empty($product_id) ? 'Add Product' : 'Update Product'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>
