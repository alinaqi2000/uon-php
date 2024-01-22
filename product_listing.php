<?php
// Include db_connection.php and necessary functions

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<li>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<div class="price">£' . $row['price'] . '</div>';
        echo '<a href="product_details.php?id=' . $row['product_id'] . '">View Details</a>';
        echo '</li>';
    }
} else {
    echo "No products available.";
}
?>
