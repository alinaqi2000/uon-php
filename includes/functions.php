<?php
function subString($string, $max = 100)
{
    if (strlen($string) > $max) {
        return substr($string, 0, $max) . "...";
    }
    return $string;
}
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
function displayAnsweredBy($name)
{
    if ($name)
        return "<span class='p-2'>$name</span>";
    return "<span class='font-weight-bold text-danger p-2'>Not Answered</span>";
}
function redirect($url)
{
    header("Location: " . $url);
    exit();
}
function countAll()
{
    $numbers = array();
    $numbers = fetchRaw("SELECT (SELECT COUNT(*) FROM products) AS products,
    (SELECT COUNT(*) FROM categories) AS categories,
    (SELECT COUNT(*) FROM customers) AS customers,
    (SELECT COUNT(*) FROM users WHERE user_type = 'employee') AS employees,
    (SELECT COUNT(*) FROM questions) AS questions,
    (SELECT COUNT(*) FROM answers) AS answers", true);
    return $numbers;
}
function countUnAnswered()
{
    $result = fetchRaw("SELECT COUNT(*) AS ua_questions FROM questions WHERE answered='0'", true);
    return $result['ua_questions'];
}
function getAllQuestions($limit = -1, $only_unanswered = false)
{
    return fetchRaw("SELECT q.*, u.full_name, c.customer_name, p.name FROM questions AS q
    LEFT JOIN customers AS c ON q.customer_id = c.customer_id 
    LEFT JOIN products AS p ON q.product_id = p.product_id 
    LEFT JOIN answers AS a ON q.question_id = a.question_id
    LEFT JOIN users AS u ON a.user_id = u.user_id
    " . ($only_unanswered ? "WHERE answered='0'" : "") . "
    ORDER BY q.answered ASC
    " . ($limit == -1 ? "" : " LIMIT 0, " . $limit));
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
function getAllProducts($limit = -1)
{
    return fetchRaw("SELECT p.*, u.full_name FROM products AS p
    LEFT JOIN users AS u ON p.user_id = u.user_id 
    " . ($limit == -1 ? "" : "LIMIT 0, " . $limit));
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

function fetchRaw($sql, $single = false)
{
    try {
        global $conn;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($single) {
            $row = $stmt->fetch();
        } else {
            $rows = $stmt->fetchAll();
        }

        $stmt->closeCursor();

        return $single ? $row : $rows;
    } catch (PDOException $e) {
        die($e->getMessage());
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
            foreach ($params as $key => $value) {
                $stmt->bindParam(":$key", $value);
            }
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $rows;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
