<?php
include('./admin/inc/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name= trim($_POST['name']);
    $email= trim($_POST['email']);
    $comment= trim($_POST['comment']);

    // Validate email field
    if (!empty($name) &&!empty($email) && !empty($comment)) {
        try {
            // Insert data into the database
            $sql = "INSERT INTO tbl_blog_comment (name,email,comment) VALUES ( :name,:email,:comment)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':comment' => $comment
            ]);

            // Show alert and redirect
            echo "<script>
                    alert('Thank You For Comments.');
                    window.location.href = 'blog-details.php';
                  </script>";
            exit;
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please enter a valid email address.');</script>";
    }
}
?>
