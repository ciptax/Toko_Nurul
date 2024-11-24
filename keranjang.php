<?php
require_once "./config.php";  // Pastikan koneksi database

session_start();  // Memulai session untuk mengakses user_id

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan error
    header("Location: ./login.php");
    exit();
}

// ID pengguna yang sedang login diambil dari session
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Cek apakah produk sudah ada di keranjang
    $stmt = $conn->prepare("SELECT * FROM keranjang WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika produk sudah ada di keranjang, tambahkan quantity
        $stmt = $conn->prepare("UPDATE keranjang SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $product_id, $user_id);
    } else {
        // Jika produk belum ada, tambahkan produk baru ke keranjang
        $stmt = $conn->prepare("INSERT INTO keranjang (product_id, quantity, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $product_id, $quantity, $user_id);
    }

    if ($stmt->execute()) {
        echo "Produk berhasil ditambahkan ke keranjang.";
    } else {
        echo "Gagal menambahkan produk ke keranjang.";
    }
}
?>
