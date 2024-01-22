<?php
$title = " Admin Dashboard";
include_once("./layout/header.php");
?>
<div class="container mt-4">
    <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>

    <!-- Add more content and features of the admin dashboard here -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Products
                </div>
                <div class="card-body">
                    <h5 class="card-title">Total Products: XX</h5>
                    <a href="#" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>
        <!-- Add more cards or sections as needed -->
    </div>
</div>
<?php include_once("./layout/footer.php"); ?>