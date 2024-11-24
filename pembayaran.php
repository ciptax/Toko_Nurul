<?php
// pembayaran.php
require_once "./config.php"; // Koneksi ke database

session_start();  // Memulai session

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan error
    header("Location: login.php");
    exit();
}

// ID pengguna yang sedang login diambil dari session
$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Jika pengguna tidak ditemukan, tampilkan pesan error
if (!$user) {
    echo "Data pengguna tidak ditemukan.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Toko Nurul SRC</title>
    <link href="assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> <!-- link ke CSS yang baru -->
</head>
<style>
    /* Reset default margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body Styling */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        line-height: 1.6;
    }

    /* Container Styling */
    .container {
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        border-radius: 8px;
        margin-top: 50px;
        max-width: 800px;
    }

    /* Title */
    h2 {
        font-size: 2.5em;
        color: #007bff;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Input Styling */
    input, select, textarea {
        font-size: 1em;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        width: 100%;
        margin-bottom: 20px;
    }

    /* Focused Input Styling */
    input:focus, select:focus, textarea:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    /* Submit Button */
    button {
        font-size: 1.2em;
        padding: 12px 25px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            margin: 20px;
            padding: 20px;
        }

        h2 {
            font-size: 2em;
        }

        button {
            font-size: 1em;
        }
    }
</style>
<body>

<div class="container mt-5">
    <h2>Informasi Pembayaran</h2>
    <form action="./proses/proses_pembayaran.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

        <!-- Alamat Pengiriman -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Pengiriman</label>
            <textarea name="alamat" id="alamat" class="form-control" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-3">
            <label for="metode" class="form-label">Metode Pembayaran</label>
            <select name="metode" id="metode" class="form-select" required>
                <option value="transfer">Transfer Bank BCA</option>
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="dana">Dana</option>
                <option value="ovo">OVO</option>
                <option value="gopay">GoPay</option>
            </select>
        </div>

        <!-- Tombol Bayar -->
        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
