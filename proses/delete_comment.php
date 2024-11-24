<?php
include "../config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];
    global $conn;

    // Pastikan komentar milik user yang login
    $sql = "DELETE FROM ulasan WHERE id = $comment_id AND user_id = {$_SESSION['user_id']}";
    if ($conn->query($sql)) {
        header("Location: ../komentar.php");
    } else {
        echo "Gagal menghapus komentar.";
    }
} else {
    header("Location: ../komentar.php");
}
?>
