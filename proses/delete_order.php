<?php
require_once "../config.php"; // Pastikan koneksi database
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah form di-submit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil order_id yang akan dihapus
    $order_id = $_POST['order_id'];

    // Pastikan order_id valid dan milik pengguna yang sedang login
    $user_id = $_SESSION['user_id'];
    
    // Mulai transaksi untuk menjaga konsistensi data
    $conn->begin_transaction();

    try {
        // Hapus data terkait di tabel order_details
        $delete_order_details_query = "
            DELETE FROM order_details 
            WHERE order_id = ? 
        ";

        $stmt = $conn->prepare($delete_order_details_query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // Hapus pesanan dari tabel orders setelah order_details dihapus
        $delete_order_query = "
            DELETE FROM orders 
            WHERE order_id = ? AND user_id = ?
        ";

        $stmt = $conn->prepare($delete_order_query);
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();

        // Jika kedua query berhasil, commit transaksi
        if ($stmt->affected_rows > 0) {
            $conn->commit();  // Commit transaksi
            // Arahkan kembali ke halaman riwayat pesanan
            header("Location: ../riwayat_pesanan.php");
            exit();
        } else {
            // Jika tidak ada baris yang terpengaruh, rollback transaksi
            $conn->rollback();
            echo "Gagal menghapus pesanan.";
        }
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        $conn->rollback();
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
