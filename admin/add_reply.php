<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$comment_id = $_POST['comment_id'];
$reply_text = $_POST['reply_text'];
$user_id = $_SESSION['user_id'];

$query = "INSERT INTO replies (comment_id, user_id, reply_text) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iis', $comment_id, $user_id, $reply_text);

if ($stmt->execute()) {
    header("Location: data_ulasan.php");
} else {
    echo "Gagal menambahkan balasan.";
}
?>
