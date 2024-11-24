<?php
session_start();
require './config.php';

// Cek apakah user login sebagai customer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesan dari customer dan balasannya
$query = "SELECT contacts.id as contact_id, contacts.message, contact_replies.reply_text, contacts.created_at, contact_replies.created_at as reply_created_at 
          FROM contacts
          LEFT JOIN contact_replies ON contacts.id = contact_replies.contact_id
          WHERE contacts.user_id = ?
          ORDER BY contacts.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Menyimpan pesan baru dari customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];

    // Simpan pesan baru ke dalam database
    $query = "INSERT INTO contacts (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $user_id, $message);
    $stmt->execute();

    // Redirect ke halaman pesan untuk melihat pesan yang dikirim
    header('Location: messages.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Chat dengan Admin</h1>

    <!-- Form untuk mengirimkan pesan ke admin -->
    <h3>Kirim Pesan Komplain</h3>
    <form action="messages.php" method="POST">
        <div class="mb-3">
            <label for="message" class="form-label">Tulis Pesan</label>
            <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
    </form>

    <!-- Riwayat Pesan -->
    <h3 class="mt-5">Riwayat Chat</h3>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Pesan Anda</h5>
                    <p class="text-muted small"><?= $row['created_at'] ?></p>
                </div>
                <p class="card-text"><?= htmlspecialchars($row['message']) ?></p>

                <?php if (!empty($row['reply_text'])) { ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Balasan Admin</h5>
                        <p class="text-muted small"><?= $row['reply_created_at'] ?></p>
                    </div>
                    <p class="card-text"><?= htmlspecialchars($row['reply_text']) ?></p>
                <?php } else { ?>
                    <p class="text-muted">Belum ada balasan dari Admin</p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
