<?php
include_once("./includes/includes.php");
$product_id = $_GET['product'];
$products = fetchRowsFromTable("products", "*", "product_id=:0", [$product_id]);
if (!$products[0]) {
    redirect("index.php");
}

$product = $products[0];
$title = $product['name'] . " - " . $product['description'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $question = $_POST['question'];
    if (!$name || !$email || !$question) {
        setFlashError("Please fill in all the required fields");
    } else {
        $customer = null;
        $customers = fetchRowsFromTable("customers", "*", "customer_email=:0", [$email]);
        $customer = $customers[0];
        $sql = "INSERT INTO customers (customer_name, customer_email) VALUES ('$name', '$email')";
        if (!$customer && $conn->query($sql) !== TRUE) {
            setFlashError("Something went wrong! Please try later.");
        } else {
            $customer_id = $customer['customer_id'] ?? $conn->lastInsertId();
            $sql = "INSERT INTO questions (product_id, customer_id, question) VALUES ('$product_id', '$customer_id', '$question')";
            if ($conn->query($sql) !== false) {
                setFlashSuccess("Question posted successfully!");
                $question_id = $conn->lastInsertId();
                redirect("product_details.php?product=" . $product_id . "#question-" .  $question_id);
            } else {
                setFlashError("Something went wrong! Please try later.");
            }
        }
    }
}

include_once("./layout/header.php");
?>
<section></section>
<main>
    <h3><?= $product['name'] ?></h3>
    <p><?= $product['description'] ?></p>
    <p><strong>Manufacturer:</strong> <?= $product['manufacturer'] ?></p>
    <p><strong>Price:</strong> <?= $product['price'] ?></p>
    <p>
        <?= nl2br($product['detail']) ?>
    </p>
    <hr />
    <h2>Want to know more? Ask any question</h2>
    <?php displayFlashMessages(); ?>
    <form action="" method="post">
        <div class="field">
            <label>Name</label>
            <input type="text" required name="name" value="<?= $_POST['name'] ?>" />
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" required name="email" value="<?= $_POST['email'] ?>" />
        </div>
        <div class="field">
            <label>Your Question</label>
            <textarea name="question"><?= $_POST['question'] ?></textarea>
        </div>
        <input type="submit" required name="submit" value="submit" />
    </form>
    <hr />
    <h4>Product questions</h4>
    <?php $questions = getProductQuestions($product_id); ?>
    <?php if (!count($questions)) : ?>
        <p>No questions asked yet!</p>
    <?php endif; ?>
    <ul class="reviews">
        <?php foreach ($questions as $question) : ?>
            <li id="question-<?= $question['q_id'] ?>">
                <p><?= nl2br($question['question']) ?></p>
                <div class="details">
                    <strong><?= $question['customer_name'] ?></strong>
                    <em><?= date("d M Y", strtotime($question['questioned_at'])) ?></em>
                </div>
            </li>
            <?php if ($question['answered']) : ?>
                <li>
                    <p><?= nl2br($question['answer']) ?></p>
                    <div class="details">
                        <strong><?= $question['full_name'] ?></strong>
                        <em><?= date("d M Y", strtotime($question['answered_at'])) ?></em>
                    </div>
                </li>
            <?php else : ?>
                <li>Not answered yet!</li>
            <?php endif; ?>
        <?php endforeach; ?>

    </ul>
</main>
<?php
include_once("./layout/footer.php");
