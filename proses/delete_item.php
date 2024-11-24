<?php
require_once "../config.php";  // Pastikan koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Hapus item dari keranjang
    $query = "DELETE FROM keranjang WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();

    // Redirect kembali ke halaman keranjang
    header("Location: ./keranjang.php");
    exit();
}
?>