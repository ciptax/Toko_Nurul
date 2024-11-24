<?php 
session_start();
include "../config.php"; 

// Cek apakah pengguna adalah admin yang sudah login
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] !== "admin") {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
}

// Inisialisasi variabel pesan
$successMessage = '';
$errorMessage = '';

// Ambil data admin yang sedang login untuk ditampilkan di form (bisa disesuaikan dengan kebutuhan)
$adminUsername = $_SESSION['username']; // Pastikan admin login sudah memiliki username di session
$query = "SELECT * FROM users WHERE username = '$adminUsername' AND role = 'admin'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Proses update akun admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newNama = $_POST['nama'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    // Enkripsi password baru
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update informasi admin di database
    $sql = "UPDATE users SET nama = ?, username = ?, password = ? WHERE username = '$adminUsername' AND role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newNama, $newUsername, $hashedPassword);

    if ($stmt->execute()) {
        // Update session dan arahkan ke halaman login
        $_SESSION['username'] = $newUsername; // Update session username
        session_destroy(); // Menghapus session setelah update berhasil
        header("Location: ../login.php");
        exit;
    } else {
        $errorMessage = "Terjadi kesalahan saat memperbarui akun.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f8fa;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        .btn-orange {
            background-color: #f57224;
            color: #ffffff;
        }
        .btn-orange:hover {
            background-color: #d4601e;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Pengaturan Akun Admin</h2>
    
    <!-- Tampilkan pesan sukses atau error -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success" role="alert">
            <?= $successMessage ?>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="peraturan_admin.php">
        <div class="form-group">
            <label for="nama">Nama Baru</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $admin['nama'] ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username Baru</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $admin['username'] ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-orange btn-block">Simpan Perubahan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
