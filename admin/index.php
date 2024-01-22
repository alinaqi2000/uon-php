<?php
include_once('./includes.php');

// Example: Check if the user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Redirect to the admin dashboard or any other admin page
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate login credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: Fetch user details from the database based on the username
    $sql = "SELECT * FROM users WHERE username = '$username' AND user_type = 'admin' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Example: Verify password using password_verify
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            // Redirect to the admin dashboard or any other admin page
            header("Location: index.php"); // Adjust the path as needed
            exit;
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
