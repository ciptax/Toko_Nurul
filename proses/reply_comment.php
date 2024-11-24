<?php
include '../config.php';
include '../comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];
    $reply_text = $_POST['reply_text'];

    if (!empty($reply_text)) {
        addReply($comment_id, $reply_text);
    }
    header("Location: ../komentar.php");
}
?>
