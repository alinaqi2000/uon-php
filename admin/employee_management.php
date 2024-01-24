<?php
$title = "Employees Management";
include_once("./layout/header.php");

if (isset($_GET['delete_employee'])) {
    $employee_id = $_GET['delete_employee'];
    $user_id = $_SESSION['admin_id'];

    $conn->query("UPDATE products SET user_id='$user_id' WHERE user_id='$employee_id'");
    $conn->query("UPDATE answers SET user_id='$user_id' WHERE user_id='$employee_id'");

    $conn->query("DELETE FROM users WHERE user_id='$employee_id'");

    setFlashSuccess("Employee deleted successfully!");
    redirect("employee_management.php");
}
$employees = fetchRowsFromTable("users", "*", "user_type=:0", ['employee']);
?>
<div class="container mt-4">
    <h2>Employee Management</h2>

    <div class="row">
        <div class="col-md-12">
            <a href="add_employee.php" class="btn btn-success">Add Employee</a>
        </div>
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Employees List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee) : ?>
                        <tr>
                            <td><?php echo $employee['user_id']; ?></td>
                            <td><?php echo $employee['full_name']; ?></td>
                            <td><?php echo $employee['username']; ?></td>
                            <td><?php echo $employee['email']; ?></td>
                            <td>
                                <a href="add_employee.php?edit_employee=<?= $employee['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_employee=<?= $employee['user_id'] ?>" onclick="return confirm('Are you sure, you want to delete this employee?')" class="btn btn-sm btn-danger">Delete</a>
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