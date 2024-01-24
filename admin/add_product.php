<?php
$product_id = $_GET['edit_product'];
$title = empty($product_id) ? 'Add Product' : 'Update Product';
include_once("./layout/header.php");


$product_name = $product_description = $product_manufacturer = $product_price  = '';
$product_category = [];
if (isset($_GET['edit_product'])) {
    $sql = "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->rowCount() == 1) {
        $product = $result->fetch();

        $product_name = $product['name'];
        $product_description = $product['description'];
        $product_detail = $product['detail'];
        $product_featured = $product['featured'];
        $product_manufacturer = $product['manufacturer'];
        $product_price = $product['price'];
        $cats = fetchRowsFromTable("product_categories", "category_id", "product_id=:0", [$product_id]);
        $product_category = array_column($cats, "category_id");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_detail = $_POST['product_detail'];
    $product_featured = $_POST['product_featured'];
    $product_manufacturer = $_POST['product_manufacturer'];
    $product_price = $_POST['product_price'];
    $product_categories = $_POST['product_category'];
    $user_id = $_SESSION['admin_id'];
    if ($product_id == "") {
        $sql = "INSERT INTO products (name, description, detail, featured, manufacturer, price, user_id) VALUES ('$product_name', '$product_description', '$product_detail', '$product_featured', '$product_manufacturer', '$product_price', '$user_id')";

        if ($conn->query($sql) !== false) {
            addProductCategories($conn->lastInsertId(), $product_categories);

            setFlashSuccess("Product added successfully!");
            redirect("product_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "UPDATE products SET name='$product_name', description='$product_description', detail='$product_detail', featured='$product_featured', manufacturer='$product_manufacturer', price='$product_price' WHERE product_id='$product_id'";

        if ($conn->query($sql) !== false) {
            addProductCategories($product_id, $product_categories);

            setFlashSuccess("Product updated successfully!");
            redirect("product_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<div class="container mt-4">
    <h2>
        <?php echo $title ?>
    </h2>

    <form method="post" action="">
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
            <label for="product_detail">Product Detail:</label>
            <textarea class="form-control" id="product_detail" name="product_detail" rows="4"><?php echo $product_detail; ?></textarea>
        </div>

        <div class="form-group">
            <label for="product_manufacturer">Manufacturer:</label>
            <input type="text" class="form-control" id="product_manufacturer" name="product_manufacturer" value="<?php echo $product_manufacturer; ?>" required>
        </div>

        <div class="form-group">
            <label for="product_price">Price:</label>
            <input type="number" class="form-control" id="product_price" name="product_price" step=".01" value="<?php echo $product_price; ?>" required>
        </div>

        <div class="form-group">
            <label for="product_category">Category:</label>
            <select class="form-control" multiple id="product_category" name="product_category[]" required>
                <?php
                $categories = getCategories();

                foreach ($categories as $category) {
                    $selected = in_array($category['category_id'], $product_category) ? 'selected' : '';
                    echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="product_featured">Featured:</label>
            <div>
                <input type="radio" id="featured_yes" name="product_featured" value="1" <?php echo $product_featured == 1 ? "checked" : ""; ?>>
                <label for="featured_yes">Yes</label>
                &nbsp; &nbsp; &nbsp;
                <input type="radio" id="featured_no" name="product_featured" value="0" <?php echo $product_featured == 0 ? "checked" : ""; ?>>
                <label for="featured_no">No</label>
            </div>
        </div>


        <button type="submit" class="btn btn-success" name="<?php echo empty($product_id) ? 'add_product' : 'update_product'; ?>">
            <?php echo empty($product_id) ? 'Add Product' : 'Update Product'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>