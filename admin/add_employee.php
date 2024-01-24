<?php
$employee_id = $_GET['edit_employee'];
$title = empty($employee_id) ? 'Add Employee' : 'Update Employee';
include_once("./layout/header.php");


$employee_name = $employee_username = $employee_email = '';

if (isset($_GET['edit_employee'])) {
    $sql = "SELECT * FROM users WHERE user_id='$employee_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->rowCount() == 1) {
        $employee = $result->fetch();
        $employee_id = $employee['user_id'];
        $employee_name = $employee['full_name'];
        $employee_email = $employee['email'];
        $employee_username = $employee['username'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_name = $_POST['employee_name'];
    $employee_email = $_POST['employee_email'];
    $employee_username = $_POST['employee_username'];
    $employee_password = password_hash($_POST['employee_password'], PASSWORD_DEFAULT);

    if (empty($_POST['employee_id'])) {
        if (count(fetchRowsFromTable("users", "*", "email=:0 OR username=:1", [$employee_email, $employee_username]))) {
            setFlashError("Employee already exists with these credentials!");
            redirect("add_employee.php");
        }

        $sql = "INSERT INTO users (full_name, email, username, password_hash, user_type) VALUES ('$employee_name', '$employee_email', '$employee_username', '$employee_password', 'employee')";

        if ($conn->query($sql) !== false) {
            setFlashSuccess("Employee added successfully!");
            redirect("employee_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $employee_id = $_POST['employee_id'];

        if (count(fetchRowsFromTable("users", "*", "user_id!=:0 AND (email=:1 OR username=:2)", [$employee_id, $employee_email, $employee_username]))) {
            setFlashError("Another employee added already exists with these credentials!");
            redirect("add_employee.php?edit_employee=" . $employee_id);
        }

        $sql = "UPDATE users SET 
        full_name='$employee_name',
        email='$employee_email',
        username='$employee_username'
        " . ($_POST['employee_password'] ? ", password_hash='$employee_password'" : "") . "
        WHERE user_id='$employee_id'";

        if ($conn->query($sql) !== false) {
            setFlashSuccess("Employee updated successfully!");
            redirect("employee_management.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<div class="container mt-4">
    <h2><?php echo $title; ?></h2>
    <div class="mt-2">
        <?php displayFlashMessages(); ?>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">

        <div class="form-group">
            <label for="employee_name">Employee Name:</label>
            <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?php echo $employee_name; ?>" required />
        </div>
        <div class="form-group">
            <label for="employee_email">Employee Email:</label>
            <input type="email" class="form-control" id="employee_email" name="employee_email" value="<?php echo $employee_email; ?>" required />
        </div>

        <div class="form-group">
            <label for="employee_username">Employee Username:</label>
            <input type="text" class="form-control" id="employee_username" name="employee_username" value="<?php echo $employee_username; ?>" required />
        </div>
        <div class="form-group">
            <label for="employee_password">Employee Password:</label>
            <input type="text" class="form-control" id="employee_password" name="employee_password" value="" <?= $employee_id ?  "" : 'required' ?> />
            <?php if ($employee_id) : ?>
                <small>Only type if you want to change</small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success" name="<?php echo empty($employee_id) ? 'add_employee' : 'update_employee'; ?>">
            <?php echo empty($employee_id) ? 'Add Employee' : 'Update Employee'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>