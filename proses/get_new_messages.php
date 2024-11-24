<?php
session_start();
require '../config.php'; // File koneksi database Anda

// Pastikan admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['new_messages' => 0]);
    exit();
}

// Hitung jumlah pesan baru
$query = "SELECT COUNT(*) AS new_messages 
          FROM contacts 
          WHERE status = 'new'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo json_encode(['new_messages' => $row['new_messages']]);
?>
