<?php
require_once "./config.php"; // Pastikan koneksi database
session_start(); // Memulai session

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pengguna yang sedang login dari session
$user_id = $_SESSION['user_id'];

// Ambil data produk di keranjang berdasarkan user_id
$query = "
    SELECT 
        k.quantity, 
        p.id AS product_id, 
        p.nama_barang, 
        p.harga, 
        p.gambar,
        p.deskripsi,
        p.stok,
        (p.harga * k.quantity) AS total_harga 
    FROM keranjang k
    JOIN prodact p ON k.product_id = p.id
    WHERE k.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_semua = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
</head>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header Section */
        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead th {
            background-color: #f1f1f1;
            text-align: left;
            padding: 10px;
            font-weight: bold;
            color: #555;
            border-bottom: 2px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        td, th {
            padding: 10px;
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
        }

        /* Image in Table */
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #ff4c4c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #e43b3b;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Footer Row Styles */
        tfoot th {
            font-size: 1.2rem;
            color: #000;
            padding: 15px;
            text-align: right;
            background-color: #f1f1f1;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            table {
                font-size: 0.9rem;
            }
            
            td img {
                display: block;
                margin: 0 auto;
            }

            .btn {
                padding: 6px 10px;
                font-size: 12px;
            }
        }
    </style>
</head

<body>
    <div class="container my-5">
        <h2 class="text-center">Keranjang Belanja </i> <?= $_SESSION['username']; ?></h2>

        <!-- Notifikasi jika ada pesan -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <img src="assets/<?= htmlspecialchars($row['gambar']) ?>" 
                                    alt="<?= htmlspecialchars($row['nama_barang']) ?>" style="width: 50px;">
                            </td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                            <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>Rp. <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                            <td>
                                <!-- Tombol Hapus dari Keranjang -->
                                <form action="./proses/hapus_dari_keranjang.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['product_id']) ?>">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total_semua += $row['total_harga']; ?>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total Keseluruhan:</th>
                        <th colspan="2">Rp. <?= number_format($total_semua, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-between mt-4" style="gap: 7px;">
                <a href="belanja.php" class="btn btn-success">Belanja Lagi</a>
                <a href="pembayaran.php" class="btn btn-success">Lanjut ke Pembayaran</a>
            </div>
        <?php else: ?>
            <p class="text-center">Keranjang Anda kosong.</p>
        <?php endif; ?>
    </div>
</body>
</html>
