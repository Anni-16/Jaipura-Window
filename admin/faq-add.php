<?php
session_start();
require_once('header.php');

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$faq_count = isset($_POST['faq_count']) ? (int)$_POST['faq_count'] : 1;

if (isset($_POST['add_faq'])) {
    $faq_count++;
}

if (isset($_POST['form1'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'Invalid CSRF token.<br>';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $faq_count = count($_POST['title'] ?? []); // Safeguard with null coalescing
    $valid = 1;
    $error_message = '';

    // At least one filled QA pair
    $has_one_filled = false;
    foreach ($_POST['title'] as $key => $title) {
        $answer = $_POST['answer'][$key] ?? '';
        if (!empty(trim($title)) && !empty(trim($answer))) {
            $has_one_filled = true;
            break;
        }
    }

    if (!$has_one_filled) {
        $valid = 0;
        $error_message .= 'Please fill at least one Question and Answer.<br>';
    }

    if ($valid == 1) {
        try {
            foreach ($_POST['title'] as $key => $title) {
                $title = trim($_POST['title'][$key] ?? '');
                $answer = trim($_POST['answer'][$key] ?? '');

                if (!empty($title) && !empty($answer)) {
                    // Validate lengths (adjust based on database schema)
                    if (strlen($title) > 255) {
                        $valid = 0;
                        $error_message .= 'Question ' . ($key + 1) . ' is too long (max 255 characters).<br>';
                        continue;
                    }

                    $statement = $pdo->prepare("INSERT INTO tbl_faq (title, answer, created_on) VALUES (?, ?, NOW())");
                    if (!$statement->execute([$title, $answer])) {
                        $valid = 0;
                        $error_message .= 'Failed to add FAQ ' . ($key + 1) . '.<br>';
                    }
                }
            }

            if ($valid == 1) {
                $_SESSION['success_message'] = 'FAQ(s) added successfully!';
                $_POST = []; // Clear form input
                $faq_count = 1;
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        } catch (PDOException $e) {
            $error_message .= 'Database error: ' . htmlspecialchars($e->getMessage()) . '<br>';
            error_log('FAQ insert error: ' . $e->getMessage());
        }
    }

    if ($error_message) {
        $_SESSION['error_message'] = $error_message;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add FAQ</h1>
    </div>
    <div class="content-header-right">
        <a href="faq.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="callout callout-danger"><p><?= $_SESSION['error_message'] ?></p></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="callout callout-success"><p><?= $_SESSION['success_message'] ?></p></div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <input type="hidden" name="faq_count" value="<?= $faq_count ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="box box-info">
                    <div class="box-body">

                        <?php for ($i = 0; $i < $faq_count; $i++): ?>
                            <div class="faq-item">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Question <?= $i + 1 ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title[]" class="form-control" value="" placeholder="Enter Question" maxlength="255">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Answer <?= $i + 1 ?></label>
                                    <div class="col-sm-9">
                                        <textarea name="answer[]" class="form-control" style="height:120px;" placeholder="Enter Answer"></textarea>
                                    </div>
                                </div>

                                <hr>
                            </div>
                        <?php endfor; ?>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="submit" name="add_faq" class="btn btn-warning">+ Add FAQ</button>
                                <button type="submit" name="form1" class="btn btn-success">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>