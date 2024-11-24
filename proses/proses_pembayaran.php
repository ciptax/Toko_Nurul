<?php
require_once "../config.php"; // Koneksi ke database

// Ambil data dari form
$user_id = $_POST['user_id']; // Sesuaikan user_id jika ada sistem autentikasi pengguna
$alamat = $_POST['alamat'];
$metode_pembayaran = $_POST['metode'];

// Simpan transaksi pembayaran ke dalam tabel orders
$order_date = date("Y-m-d H:i:s");

// Memulai transaksi database untuk memastikan integritas data
$conn->begin_transaction();

try {
    // Menyimpan data pesanan
    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, alamat, metode_pembayaran) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $order_date, $alamat, $metode_pembayaran);
    $stmt->execute();
    
    // Mendapatkan ID pesanan terbaru
    $order_id = $stmt->insert_id;

    // Ambil semua item dari keranjang
    $result = $conn->query("SELECT product_id, quantity FROM keranjang WHERE user_id = $user_id");

    // Iterasi melalui setiap item keranjang dan simpan detailnya ke tabel orders
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        // Simpan detail pesanan ke tabel order_details atau sejenisnya
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $order_id, $product_id, $quantity);
        $stmt->execute();

        // Update stok produk
        $stmt = $conn->prepare("UPDATE prodact SET stok = stok - ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $product_id);
        $stmt->execute();
    }

    // Hapus item dari keranjang setelah disimpan ke dalam orders
    $conn->query("DELETE FROM keranjang WHERE user_id = $user_id");

    // Commit transaksi jika semua berhasil
    $conn->commit();

    // Tampilkan pesan sukses
    echo "Pembayaran berhasil! Terima kasih sudah berbelanja.";
} catch (Exception $e) {
    // Rollback jika terjadi kesalahan
    $conn->rollback();
    echo "Pembayaran gagal: " . $e->getMessage();
}
header("Location: ../riwayat_pesanan.php");
        exit(); // Menghentikan eksekusi lebih lanjut
?>
