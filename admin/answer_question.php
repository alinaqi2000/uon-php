<?php
$question_id = $_GET['question'];
$title = 'Manage Question';
include_once("./layout/header.php");

$user_id = $_SESSION['admin_id'];
$question_answer = '';

if (isset($_GET['question'])) {
    $sql = "";
    $question = fetchRaw("SELECT q.*, c.customer_name, c.customer_email, p.name FROM questions AS q
    LEFT JOIN customers AS c ON q.customer_id = c.customer_id 
    LEFT JOIN products AS p ON q.product_id = p.product_id 
    WHERE question_id='$question_id'
    LIMIT 1", true);
    if (empty($question)) {
        redirect("question_management.php");
    }
    $answer = fetchRaw("SELECT * FROM answers WHERE question_id='$question_id' LIMIT 1", true);
    $question_answer = $answer['answer'];
} else {
    redirect("question_management.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_answer = $_POST['question_answer'];

    if (empty($_POST['answer_id'])) {
        $sql = "INSERT INTO answers (question_id, user_id, answer) VALUES ('$question_id', '$user_id','$question_answer')";
        
        
        if ($conn->query($sql) === TRUE) {
            $conn->query("UPDATE questions SET answered=1 WHERE question_id='$question_id'");
           
            setFlashSuccess("Answer added successfully!");
            redirect("answer_question.php?question=" . $question_id);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $answer_id = $_POST['answer_id'];
        $sql = "UPDATE answers SET answer='$question_answer' WHERE answer_id='$answer_id'";

        if ($conn->query($sql) === TRUE) {
            setFlashSuccess("Answer updated successfully!");
            redirect("answer_question.php?question=" . $question_id);
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
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="10%">Question:</th>
                <td><?= nl2br($question['question']) ?></td>
                <th width="15%" class="text-right">Date:</th>
                <td width="20%"><?= date("d M Y H:i A") ?></td>
            </tr>
            <tr>
                <th width="10%">Product:</th>
                <td><?= $question['name'] ?></td>
                <th width="15%" class="text-right">Customer:</th>
                <td width="20%">
                    <?= $question['customer_name'] ?>
                    <br />
                    <i><?= $question['customer_email'] ?></i>
                </td>
            </tr>
        </tbody>
    </table>
    <form method="post" action="">
        <input type="hidden" name="answer_id" value="<?php echo $answer['answer_id']; ?>">

        <div class="form-group">
            <label for="question_answer">Answer:</label>
            <textarea class="form-control" id="question_answer" name="question_answer" rows="4"><?php echo $question_answer; ?></textarea>
        </div>

        <button type="submit" class="btn btn-success" name="<?php echo empty($question_id) ? 'add_question' : 'update_question'; ?>">
            <?php echo empty($answer) ? 'Add Answer' : 'Update Answer'; ?>
        </button>
    </form>
</div>

<?php include_once("./layout/footer.php"); ?>