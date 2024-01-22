<?php
// Include db_connection.php and necessary functions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming user authentication is implemented, get user ID
    $userId = 1; // Replace with actual user ID

    $productId = $_POST['product_id'];
    $question = $_POST['question'];

    // Insert question into the database
    $insertQuestionSql = "INSERT INTO questions (product_id, user_id, question, date_time) VALUES ($productId, $userId, '$question', NOW())";
    if ($conn->query($insertQuestionSql) === TRUE) {
        echo "Question submitted successfully.";
    } else {
        echo "Error: " . $insertQuestionSql . "<br>" . $conn->error;
    }
}
?>
