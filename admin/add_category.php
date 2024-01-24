<?php
$category_id = $_GET['edit_category'];
$title = empty($category_id) ? 'Add Category' : 'Update Category';
include_once("./layout/header.php");


$category_name = '';

if (isset($_GET['edit_category'])) {
  $sql = "SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->rowCount() == 1) {
        $category = $result->fetch();
        $category_id = $category['category_id'];
        $category_name = $category['category_name'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    if (empty($_POST['category_id'])) {
        $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";

        if ($conn->query($sql) !== false) {
            setFlashSuccess("Category added successfully!");
            redirect("category_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $category_id = $_POST['category_id'];
        $sql = "UPDATE categories SET category_name='$category_name' WHERE category_id='$category_id'";

        if ($conn->query($sql) !== false) {
            setFlashSuccess("Category updated successfully!");
            redirect("category_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<div class="container mt-4">
    <h2><?php echo $title; ?></h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>" required>
        </div>

        <button type="submit" class="btn btn-success" name="<?php echo empty($category_id) ? 'add_category' : 'update_category'; ?>">
            <?php echo empty($category_id) ? 'Add Category' : 'Update Category'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>