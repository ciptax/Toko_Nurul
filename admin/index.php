<?php 
session_start();
include "../config.php"; 

// Validasi akses hanya untuk admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil total stok barang dari tabel prodact
$sqlTotalStok = "SELECT SUM(stok) AS total_stok FROM prodact";
$resultTotalStok = $conn->query($sqlTotalStok);
$totalStok = $resultTotalStok->fetch_assoc()['total_stok'] ?? 0;

// Ambil jumlah kategori dari tabel kategori
$sqlTotalKategori = "SELECT COUNT(DISTINCT kategori) AS total_kategori FROM prodact";
$resultTotalKategori = $conn->query($sqlTotalKategori);
$totalKategori = $resultTotalKategori->fetch_assoc()['total_kategori'] ?? 0;

// Ambil jumlah customers dari tabel customers
$sqlTotalCustomers = "SELECT COUNT(*) AS total_customers FROM users WHERE role = 'customer'";
 // Sesuaikan dengan nama tabel customers
$resultTotalCustomers = $conn->query($sqlTotalCustomers);
$totalCustomers = $resultTotalCustomers->fetch_assoc()['total_customers'] ?? 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nurul SRC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    /* Responsif untuk Navbar */
.navbar {
    background: linear-gradient(180deg, #3a3a3a, #2c2c2c);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
    color: #fff;
}
.navbar-dark .nav-link {
    color: #fff;
    transition: color 0.3s;
}
.navbar-dark .nav-link:hover {
    color: #FFC107;
}

/* Sidebar Responsif */
.sidebar {
    background: linear-gradient(180deg, #3a3a3a, #2c2c2c);
    min-height: 100vh;
    color: #ffffff;
    padding-top: 20px;
}
.sidebar .nav-link {
    color: #B8C1C8;
    transition: color 0.3s;
}
.sidebar .nav-link:hover {
    color: #f57224;
}
.sidebar .dropdown-toggle::after {
    color: #B8C1C8;
}

/* Styling Sidebar di Layar Kecil */
@media (max-width: 768px) {
    .sidebar {
        position: absolute;
        width: 100%;
        height: auto;
        z-index: 1000;
    }
    .sidebar .nav-item {
        text-align: center;
        margin: 10px 0;
    }
    .sidebar .nav-link {
        display: inline-block;
    }
}

/* Card Responsif */
.card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    margin-top: 23px;
}
.card:hover {
    transform: translateY(-5px);
}
.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #f57224;
}

/* Grid Responsif */
@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    .container {
        padding: 0 15px;
    }
}

</style>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Nurul SRC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            <li><a class="dropdown-item" href="./peraturan_admin.php"><i class="fas fa-cog"></i> Pengaturan Akun</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#dataMenu">
                                <i class="fas fa-database"></i> Data
                            </a>
                            <ul class="collapse" id="dataMenu">
                                <li><a class="nav-link" href="./data_produk.php"><i class="fas fa-box"></i> Data Barang</a></li>
                                <li><a class="nav-link" href="./data_customers.php"><i class="fas fa-users"></i> Data Customers</a></li>
                                <li><a class="nav-link" href="./data_kategori.php"><i class="fas fa-tags"></i> Data Kategori</a></li>
                                <li><a class="nav-link" href="./data_ulasan.php"><i class=""></i> Data Ulasan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#laporanMenu">
                                <i class="fas fa-chart-line"></i> Laporan
                            </a>
                            <ul class="collapse" id="laporanMenu">
                                <li><a class="nav-link" href="./laporan_penjualan.php"><i class="fas fa-chart-line"></i> Penjualan</a></li>
                                <li><a class="nav-link" href="./laporan_keuangan.php"><i class="fas fa-coins"></i> Keuangan</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten Utama -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-4">
                    <h2>Dashboard</h2>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12">
                            <!-- Kartu Total Stok Barang -->
                            <a href="data_produk.php" class="text-decoration-none text-dark">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-boxes"></i> Total Stok Barang</h5>
                                        <p class="card-text fs-3 fw-bold">
                                            <?= $totalStok ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <!-- Kartu Jumlah Kategori -->
                            <a href="data_kategori.php" class="text-decoration-none text-dark">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-tags"></i> Jumlah Kategori</h5>
                                        <p class="card-text fs-3 fw-bold">
                                            <?= $totalKategori ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <!-- Kartu Jumlah Customers -->
                            <a href="data_customers.php" class="text-decoration-none text-dark">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-users"></i> Jumlah Customers</h5>
                                        <p class="card-text fs-3 fw-bold"><?= $totalCustomers ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <!-- Kartu Laporan Keuangan -->
                            <a href="laporan_keuangan.php" class="text-decoration-none text-dark">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-coins"></i> Laporan Keuangan</h5>
                                        <p class="card-text fs-3 fw-bold">$</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <!-- Kartu Laporan Penjualan -->
                            <a href="laporan_penjualan.php" class="text-decoration-none text-dark">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-chart-line"></i> Laporan Penjualan</h5>
                                        <p class="card-text fs-3 fw-bold">+</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: { /* Data keuangan */ }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
