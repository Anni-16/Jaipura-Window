<?php require_once('header.php'); ?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: faq.php');
    exit;
}

$faq_id = $_GET['id'];

// Fetch the existing FAQ
$statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE id = ?");
$statement->execute([$faq_id]);
$faq = $statement->fetch(PDO::FETCH_ASSOC);

if (!$faq) {
    header('location: faq.php');
    exit;
}

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $title = trim($_POST['title']);
    $answer = trim($_POST['answer']);

    if (empty($title)) {
        $error_message .= 'Question cannot be empty.<br>';
    }
    if (empty($answer)) {
        $error_message .= 'Answer cannot be empty.<br>';
    }

    if ($error_message === '') {
        // Update the FAQ with meta data
        $statement = $pdo->prepare("UPDATE tbl_faq SET title = ?,  answer = ? WHERE id = ?");
        $statement->execute([$title, $answer , $faq_id]);

        $success_message = 'FAQ updated successfully!';
        // Update the local variable too, to reflect on the form
        $faq['title'] = $title;
        $faq['answer'] = $answer;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit FAQ</h1>
    </div>
    <div class="content-header-right">
        <a href="faq.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Question <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" value="<?php echo $faq['title']; ?>" placeholder="Enter Question">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="answer" class="col-sm-2 control-label">Answer <span>*</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="answer" placeholder="Enter Answer" style="height:200px;"><?php echo $faq['answer']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
