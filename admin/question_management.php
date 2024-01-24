<?php
$title = "Questions Management";
include_once("./layout/header.php");

if (isset($_GET['delete_question'])) {
    $question_id = $_GET['delete_question'];

    $conn->query("DELETE FROM answers WHERE question_id='$question_id'");
    $conn->query("DELETE FROM questions WHERE question_id='$question_id'");

    setFlashSuccess("Question deleted successfully!");
    redirect("question_management.php");
}
$questions = getAllQuestions();
?>
<div class="container mt-4">
    <h2>Question Management</h2>

    <div class="row">
        <div class="col-md-12 mt-2">
            <?php displayFlashMessages(); ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Questions List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Product</th>
                        <th>Question</th>
                        <th width="15%">Date</th>
                        <th width="15%">Asked By</th>
                        <th width="15%">Answered By</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!count($questions)) : ?>
                        <tr>
                            <td colspan="3" class="text-center">No questions found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($questions as $question) : ?>
                        <tr>
                            <td><?php echo $question['question_id']; ?></td>
                            <td><?php echo $question['name']; ?></td>
                            <td><?php echo $question['question']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($question['questioned_at'])); ?></td>
                            <td><?php echo $question['customer_name']; ?></td>
                            <td><?php echo displayAnsweredBy($question['full_name']); ?></td>
                            <td>
                                <a href="answer_question.php?question=<?= $question['question_id'] ?>" class="btn btn-sm btn-primary">View</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_question=<?= $question['question_id'] ?>" onclick="return confirm('Are you sure, you want to delete this question?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    const table = $('table').dataTable();
    table.fnSort([
        [5, 'desc']
    ]);
</script>
<?php include_once("./layout/footer.php"); ?>