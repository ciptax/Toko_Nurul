<?php
require_once "../config.php"; // Pastikan koneksi database
session_start(); // Memulai session

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Hapus produk dari keranjang
    $query = "DELETE FROM keranjang WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $product_id, $user_id);

    if ($stmt->execute()) {
        // Redirect ke belanja.php setelah berhasil
        header("Location: ../belanja.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus produk.";
    }
}
?>
