<?php
$title = "Categories Management";
include_once("./layout/header.php");

if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];

    $conn->query("DELETE FROM product_categories WHERE category_id='$category_id'");
    $conn->query("DELETE FROM categories WHERE category_id='$category_id'");

    setFlashSuccess("Category deleted successfully!");
    redirect("category_management.php");
}
$categories = fetchRowsFromTable("categories");
?>
<div class="container mt-4">
    <h2>Category Management</h2>

    <div class="row">
        <div class="col-md-12">
            <a href="add_category.php" class="btn btn-success">Add Category</a>
        </div>
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Categories List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?php echo $category['category_id']; ?></td>
                            <td><?php echo $category['category_name']; ?></td>
                            <td>
                                <a href="add_category.php?edit_category=<?= $category['category_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_category=<?= $category['category_id'] ?>" onclick="return confirm('Are you sure, you want to delete this category?')" class="btn btn-sm btn-danger">Delete</a>
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