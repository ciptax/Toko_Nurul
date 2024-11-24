<?php
require_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    // Mulai transaksi untuk menjaga konsistensi data
    $conn->begin_transaction();

    try {
        // Ambil data produk dan jumlah yang dipesan dari order_details
        $query = "
            SELECT product_id, quantity 
            FROM order_details 
            WHERE order_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kembalikan stok produk
        while ($row = $result->fetch_assoc()) {
            $update_stock_query = "
                UPDATE prodact 
                SET stok = stok + ? 
                WHERE id = ?
            ";
            $update_stmt = $conn->prepare($update_stock_query);
            $update_stmt->bind_param("ii", $row['quantity'], $row['product_id']);
            $update_stmt->execute();
        }

        // Perbarui status pesanan menjadi "canceled"
        $update_order_status_query = "
            UPDATE orders 
            SET status = 'batal' 
            WHERE order_id = ?
        ";
        $update_status_stmt = $conn->prepare($update_order_status_query);
        $update_status_stmt->bind_param("i", $order_id);
        $update_status_stmt->execute();

        // Commit transaksi
        $conn->commit();

        header("Location: ../riwayat_pesanan.php?message=Pesanan berhasil dibatalkan");
        exit();
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>
