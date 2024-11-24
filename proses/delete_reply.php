<?php
include '../config.php';
session_start();

if (isset($_GET['id'])) {
    $reply_id = $_GET['id'];

    // Hapus balasan yang sesuai dengan ID dan user yang login
    $sql = "DELETE FROM replies WHERE id = $reply_id AND user_id = {$_SESSION['user_id']}";
    if ($conn->query($sql)) {
        header('Location: ../komentar.php');  // Redirect setelah menghapus
    } else {
        echo "Gagal menghapus balasan.";
    }
} else {
    echo "Balasan tidak ditemukan.";
}
