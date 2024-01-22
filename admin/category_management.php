<?php
$title = "Categories Management";
include_once("./layout/header.php");

if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];
    $sql = "DELETE FROM categories WHERE category_id='$category_id'";

    if ($conn->query($sql) === TRUE) {
        setFlashSuccess("Category deleted successfully!");
        redirect("category_management.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$categories = fetchRowsFromTable("categories");
?>
<div class="container mt-4">
    <h2>Category Management</h2>

    <div class="row">
        <div class="col-md-12">
            <a href="add_category.php" class="btn btn-primary">Add Category</a>
        </div>
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>


    <!-- Display Existing Categories -->
    <div class="card mt-4">
        <div class="card-header">
            Categories List
        </div>
        <div class="card-body">
            <!-- Display a table with existing categories -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Name</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!count($categories)) : ?>
                        <tr>
                            <td colspan="3" class="text-center">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?php echo $category['category_id']; ?></td>
                            <td><?php echo $category['category_name']; ?></td>
                            <td>
                                <a href="add_category.php?edit_category=<?= $category['category_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_category=<?= $category['category_id'] ?>" onclick="return confirm('Are you sure, you want to delete this category?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once("./layout/footer.php"); ?>