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
function getAllProducts($limit = -1)
{
    return fetchRaw("SELECT * FROM products " . ($limit == -1 ? "" : "LIMIT 0, " . $limit));
}
function getCategoryProducts($category_id)
{
    return fetchRaw("SELECT p.* FROM product_categories as pc
    JOIN products as p ON p.product_id = pc.product_id
    WHERE pc.category_id = $category_id
    GROUP BY p.product_id ");
}
function getFeaturedProducts($limit = -1)
{
    return fetchRaw("SELECT * FROM products WHERE featured=1 " . ($limit == -1 ? "" : "LIMIT 0, " . $limit));
}
function getProductQuestions($product_id)
{
    return fetchRaw("SELECT COALESCE(q.question_id, a.question_id) as q_id, q.*, a.*, c.*, u.*
    FROM questions AS q
    LEFT JOIN answers AS a ON q.question_id = a.question_id
    LEFT JOIN customers AS c ON q.customer_id = c.customer_id
    LEFT JOIN users AS u ON a.user_id = u.user_id
    WHERE q.product_id = $product_id");
}
function getCategories()
{
    return fetchRowsFromTable("categories");
}
function addProductCategories($product_id, $categories)
{
    global $conn;
    $conn->query("DELETE FROM product_categories WHERE product_id='$product_id'");

    foreach ($categories as $category_id) {
        $conn->query("INSERT INTO product_categories (product_id, category_id) VALUES ('$product_id', '$category_id')");
    }
}

function fetchRaw($sql)
{
    try {
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $rows;
    } catch (\Throwable $th) {
        die($th->getMessage());
    }
}
function fetchRowsFromTable($table, $columns = "*", $condition = "", $params = array())
{
    try {
        global $conn;

        $allowed_tables = array("products", "categories", "product_categories", "users", "customers", "questions", "answers");

        if (!in_array($table, $allowed_tables)) {
            return false;
        }
        $sql = "SELECT $columns FROM $table";

        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    } catch (\Throwable $th) {
        die($th->getMessage());
    }
}
