<?php
$title = " Admin Dashboard";
include_once("./layout/header.php");
?>
<div class="container mt-4">
    <h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>
    <?php
    $count = countAll();
    ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header bg-dark text-white">
                    Products
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Total Products: <strong><?= $count['products'] ?></strong></h6>
                    <a href="product_management.php" class="btn btn-sm btn-dark">Manage Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header bg-dark text-white">
                    Categories
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Total Categories: <strong><?= $count['categories'] ?></strong></h6>
                    <a href="category_management.php" class="btn btn-sm btn-dark">Manage Categories</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header bg-dark text-white">
                    Customers
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Total Customers: <strong><?= $count['customers'] ?></strong></h6>
                    <a href="customer_management.php" class="btn btn-sm btn-dark">Manage Customers</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header bg-dark text-white">
                    Questions
                </h5>
                <div class="card-body">
                    <h6 class="card-title">Total Questions: <strong><?= $count['questions'] ?></strong></h6>
                    <h6 class="card-title">Total Answers: <strong><?= $count['answers'] ?></strong></h6>
                    <a href="question_management.php" class="btn btn-sm btn-dark">Manage Questions</a>
                </div>
            </div>
        </div>


        <?php if ($_SESSION['admin_type'] == 'admin') : ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <h5 class="card-header bg-dark text-white">
                        Employees
                    </h5>
                    <div class="card-body">
                        <h6 class="card-title">Total Employees: <strong><?= $count['employees'] ?></strong></h6>
                        <a href="product_management.php" class="btn btn-sm btn-dark">Manage Employees</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include_once("./layout/footer.php"); ?>