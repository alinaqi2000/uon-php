<?php
$title = "Categories Management";
include_once("./layout/header.php");

if (isset($_GET['delete_customer'])) {
    $customer_id = $_GET['delete_customer'];

    try {
        $conn->query("DELETE a FROM questions q
    LEFT JOIN answers a ON q.question_id = a.question_id
    WHERE q.customer_id='$customer_id'");
        $conn->query("DELETE FROM questions WHERE customer_id='$customer_id'");
    } catch (\Throwable $th) {
        die($th->getMessage());
    }
    $conn->query("DELETE FROM customers WHERE customer_id='$customer_id'");

    setFlashSuccess("Customer deleted successfully!");
    redirect("customer_management.php");
}
$customers = fetchRowsFromTable("customers");
?>
<div class="container mt-4">
    <h2>Customer Management</h2>

    <div class="row">
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
                        <th>Email</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer) : ?>
                        <tr>
                            <td><?php echo $customer['customer_id']; ?></td>
                            <td><?php echo $customer['customer_name']; ?></td>
                            <td><?php echo $customer['customer_email']; ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_customer=<?= $customer['customer_id'] ?>" onclick="return confirm('Are you sure, you want to delete this customer?')" class="btn btn-sm btn-danger">Delete</a>
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