<?php

function setFlashError($message)
{
    $_SESSION['flash_error'] = $message;
}
function setFlashSuccess($message)
{
    $_SESSION['flash_success'] = $message;
}
function displayFlashMessages()
{
    if (isset($_SESSION['flash_error'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['flash_error'] . '</div>';
        unset($_SESSION['flash_error']);
    }

    if (isset($_SESSION['flash_success'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['flash_success'] . '</div>';
        unset($_SESSION['flash_success']);
    }
}
function redirect($url)
{
    header("Location: " . $url);
    exit();
}
function fetchRowsFromTable($table, $columns = "*", $condition = "", $params = array())
{
    global $conn;

    $allowed_tables = array("products", "categories", "product_categories", "users", "questions");
    if (!in_array($table, $allowed_tables)) {
        return false;
    }

    // Construct the SQL query
    $sql = "SELECT $columns FROM $table";

    // Add condition if provided
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters if provided
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Assume all parameters are strings, adjust as needed
        $stmt->bind_param($types, ...$params);
    }

    // Execute the SQL statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch rows as an associative array
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    return $rows;
}
