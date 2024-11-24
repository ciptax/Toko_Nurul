<?php
// Koneksi ke database
include '../config.php';

// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mengambil data pengguna berdasarkan user_id yang login
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data pengguna
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit;
}

// Proses update data pengguna jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $nomor_hp = $_POST['nomor_hp'];

    // Validasi input
    if (empty($nama) || empty($username) || empty($alamat) || empty($nomor_hp)) {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
    } else {
        // Update data pengguna
        $sql_update = "UPDATE users SET nama = '$nama', username = '$username', alamat = '$alamat', nomor_hp = '$nomor_hp' WHERE id = $user_id";
        if ($conn->query($sql_update) === TRUE) {
            echo "<script>alert('Data berhasil diperbarui!');</script>";
            header("Location: akun_setting.php"); // Refresh halaman setelah update
        } else {
            echo "<script>alert('Gagal memperbarui data.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pengaturan Akun</h2>
        <form method="POST" action="akun_setting.php">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $user['alamat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nomor_hp" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?= $user['nomor_hp']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
