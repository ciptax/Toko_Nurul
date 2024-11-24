<?php
require '../config.php';

$id = $_GET['id'];

$query = "DELETE FROM replies WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header("Location: data_ulasan.php");
} else {
    echo "Gagal menghapus balasan.";
}
?>
