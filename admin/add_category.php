<?php
$category_id = $_GET['edit_category'];
$title = empty($category_id) ? 'Add Category' : 'Update Category';
include_once("./layout/header.php");


// Initialize variables for the form
$category_name = '';

// Check if the form is in "Update Category" mode
if (isset($_GET['edit_category'])) {
    // Fetch existing category details from the database
    // Example: Implement your logic to fetch category details based on $category_id
    $sql = "SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();

        // Set form variables with existing category details
        $category_id = $category['category_id'];
        $category_name = $category['category_name'];
    }
}

// Handle form submissions for adding/editing categories
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $category_name = $_POST['category_name'];

    // Check if the form is in "Add Category" mode
    if (empty($_POST['category_id'])) {
        // Add Category Logic
        $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";

        if ($conn->query($sql) === TRUE) {
            setFlashSuccess("Category added successfully!");
            redirect("category_management.php");
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Update Category Logic
        $category_id = $_POST['category_id'];
        $sql = "UPDATE categories SET category_name='$category_name' WHERE category_id='$category_id'";

        if ($conn->query($sql) === TRUE) {
            setFlashSuccess("Category updated successfully!");
            redirect("category_management.php");
        } else {
            // Error handling
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

        <button type="submit" class="btn btn-primary" name="<?php echo empty($category_id) ? 'add_category' : 'update_category'; ?>">
            <?php echo empty($category_id) ? 'Add Category' : 'Update Category'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>