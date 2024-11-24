<?php
include "./config.php"; // Koneksi ke database
include "./services/Auth.php"; // File berisi fungsi `register` yang sudah dibuat

// Proses registrasi jika form dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat']; // Ambil data alamat
    $nomor_hp = $_POST['nomor_hp']; // Ambil data nomor_hp
    $role = "customer"; // Role default

    // Panggil fungsi register
    if (register($nama, $username, $password, $role, $alamat, $nomor_hp)) {
        // Jika berhasil, arahkan ke halaman login
        header("Location: login.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        $error = "Registrasi gagal. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    /* Tambahkan di file CSS Anda atau di bagian <style> di halaman */
body {
    background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('assets/items/login.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    color: #fff;
}

/* Card Style */
.card {
    background: rgba(255, 255, 255, 0.1); Transparan
    backdrop-filter: blur(10px); /* Efek blur */
    border-radius: 13px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.7s ease-out;
    color: #fff;
}

.card-header {
    background-color: #f57224; /* Warna utama */
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
    border-radius: 15px 15px 0 0;
    text-align: center;
}

.card-body {
    padding: 30px;
}

.card-footer {
    background: transparent;
    border-top: none;
    text-align: center;
}

.form-control {
    background: rgba(255, 255, 255, 0.2); /* Transparan */
    border: 1px solid rgba(255, 255, 255, 0.5);
    color: #fff;
    border-radius: 10px;
    padding: 10px;
    font-size: 16px;
    transition: 0.3s;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.3);
    border-color: #f57224;
    box-shadow: 0 0 8px rgba(245, 114, 36, 0.8);
    color: #fff;
}

.btn-primary {
    background-color: #f57224;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    transition: 0.3s;
    font-size: 16px;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #d65e20;
    transform: translateY(-3px);
}

/* Pesan Error */
.alert {
    border-radius: 10px;
    font-size: 14px;
    background-color: rgba(255, 0, 0, 0.7);
    color: #fff;
}

/* Animasi */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan pesan error jika registrasi gagal -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>
                        <!-- Form Register -->
                        <form action="register.php" method="POST">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor_hp">Nomor HP</label>
                                <input type="text" name="nomor_hp" id="nomor_hp" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>&copy; 2024 Your Company</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
