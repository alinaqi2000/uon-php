<?php
// Include db_connection.php and necessary functions

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details from the database
    $productSql = "SELECT * FROM products WHERE product_id = $productId";
    $productResult = $conn->query($productSql);

    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();

        // Fetch questions and answers for the product
        $qaSql = "SELECT * FROM questions JOIN answers ON questions.question_id = answers.question_id WHERE questions.product_id = $productId";
        $qaResult = $conn->query($qaSql);

        echo '<h2>' . $product['name'] . '</h2>';
        echo '<h4>Product details</h4>';
        echo '<p>' . $product['description'] . '</p>';
        echo '<div class="price">£' . $product['price'] . '</div>';

        echo '<h4>Product Q&A</h4>';
        echo '<ul class="qa-list">';
        while ($qa = $qaResult->fetch_assoc()) {
            echo '<li>';
            echo '<p>' . $qa['question'] . '</p>';
            echo '<p>' . $qa['answer'] . '</p>';
            echo '<div class="details">';
            echo '<strong>' . $qa['user_id'] . '</strong>';
            echo '<em>' . $qa['date_time'] . '</em>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';

        // Form to ask a question (Assuming user authentication is implemented)
        echo '<h4>Ask a Question</h4>';
        echo '<form action="ask_question.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . $productId . '" />';
        echo '<label>Your Question</label> <textarea name="question" required></textarea>';
        echo '<input type="submit" name="submit" value="Ask Question" />';
        echo '</form>';
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>
