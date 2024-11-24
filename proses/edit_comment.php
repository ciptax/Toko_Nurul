<?php
include "../config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];
    global $conn;

    // Ambil komentar berdasarkan ID
    $sql = "SELECT komentar FROM ulasan WHERE id = $comment_id AND user_id = {$_SESSION['user_id']}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $comment = $result->fetch_assoc();
    } else {
        echo "Komentar tidak ditemukan atau Anda tidak memiliki izin.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $new_comment = $_POST['komentar'];
        $sql_update = "UPDATE ulasan SET komentar = '$new_comment' WHERE id = $comment_id";

        if ($conn->query($sql_update)) {
            header("Location: ../komentar.php");
        }
    }
} else {
    header("Location: ../komentar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Komentar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .form-container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-warning {
            background-color: #ffdb00;
            border: none;
            color: #333;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e6c200;
            color: #000;
        }

        h4 {
            color: #f57224;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" class="form-container">
        <h4 class="text-center mb-4">Edit Komentar</h4>
        <div class="mb-3">
            <label for="komentar" class="form-label">Komentar</label>
            <textarea 
                id="komentar" 
                name="komentar" 
                class="form-control" 
                rows="5" 
                required 
                placeholder="Tulis komentar Anda di sini"><?= $comment['komentar'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-warning w-100">Simpan Perubahan</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

