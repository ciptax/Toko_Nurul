<?php
include '../config.php'; // Koneksi ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus produk berdasarkan id
    $sql = "DELETE FROM prodact WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter id sebagai integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Produk berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan saat menghapus produk.";
    }

    // Redirect kembali ke halaman produk setelah menghapus
    header("Location: data_produk.php");
    exit();
}
?>
