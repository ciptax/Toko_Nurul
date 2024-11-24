<?php
require_once "./config.php"; // Pastikan koneksi database
session_start(); // Memulai session

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ID pengguna yang sedang login diambil dari session
$user_id = $_SESSION['user_id'];

// Ambil data pesanan dari tabel `orders` berdasarkan user_id
$query = "
    SELECT 
        o.order_id, 
        o.order_date, 
        o.alamat, 
        o.metode_pembayaran,
        o.status
    FROM 
        orders o
    WHERE 
        o.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Cek pesanan dengan status pending untuk notifikasi
$pending_query = "
    SELECT COUNT(*) AS total_pending
    FROM orders
    WHERE user_id = ? AND status = 'pending'
";
$pending_stmt = $conn->prepare($pending_query);
$pending_stmt->bind_param("i", $user_id);
$pending_stmt->execute();
$pending_result = $pending_stmt->get_result();
$pending_data = $pending_result->fetch_assoc();
$total_pending = $pending_data['total_pending'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Riwayat Pesanan <?= $_SESSION['username']; ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css"> <!-- Link ke file CSS yang baru -->
    </head>
    <style>
            /* Reset Margin dan Padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
        }

        /* Header Styling */
        header {
            background-color: #f57224;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5em;
            font-weight: 500;
        }

        /* Container Styling */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Notifikasi Pesanan */
        .notification {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #ffeeba;
            font-size: 1.1em;
        }

        /* Card Pesanan */
        .order-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .order-card:hover {
            transform: scale(1.02);
        }

        .order-card h3 {
            font-size: 1.6em;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 15px;
        }

        /* Detail Pesanan */
        .order-details {
            font-size: 1.1em;
            color: #555;
            line-height: 1.8;
        }

        .order-details div {
            margin-bottom: 10px;
        }

        /* Status Pesanan */
        .order-details .status {
            font-weight: bold;
            color: #28a745;
        }

        .order-details .status.pending {
            color: #ffc107;
        }

        .order-details .status.cancelled {
            color: #dc3545;
        }

        /* Pesan Kosong */
        .text-center {
            text-align: center;
            font-size: 1.2em;
            color: #6c757d;
        }

        /* Responsif */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }

            .order-card {
                padding: 15px;
            }
            
            .order-details {
                font-size: 1em;
            }
        }
        /* Gaya untuk tombol secara umum */
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Gaya untuk tombol Batalkan Pesanan */
        .btn-danger {
            background-color: #e74c3c; /* Merah untuk tombol batalkan */
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b; /* Warna lebih gelap saat hover */
        }

        /* Gaya untuk tombol Hapus Pesanan */
        .btn-delete {
            background-color: #f39c12; /* Kuning untuk tombol hapus */
            color: white;
        }

        .btn-delete:hover {
            background-color: #e67e22; /* Warna lebih gelap saat hover */
        }

        /* Gaya untuk disabled button */
        .btn.disabled {
            background-color: #bdc3c7; /* Warna abu-abu jika disabled */
            cursor: not-allowed;
        }

    </style>
        <body>
            <header>
                <h1>Riwayat Pesanan </i> <?= $_SESSION['username']; ?></h1>
            </header>
            <div class="container">
                <!-- Menampilkan notifikasi jika ada pesanan pending -->
                <?php if ($total_pending > 0): ?>
                    <div class="notification">
                        </i> <?= $_SESSION['username']; ?> Anda memiliki <strong><?= $total_pending ?></strong> pesanan baru yang menunggu konfirmasi.
                    </div>
                <?php endif; ?>

                <!-- Menampilkan riwayat pesanan -->
                <!-- Menampilkan riwayat pesanan -->
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="order-card">
                            <h3>Pesanan ID: <?= htmlspecialchars($row['order_id']) ?></h3>
                            <div class="order-details">
                                <div>ID Pesanan: <?= htmlspecialchars($row['order_id']) ?></div>
                                <div>Tanggal: <?= date("d F Y", strtotime($row['order_date'])) ?></div>
                                <div>Alamat: <?= htmlspecialchars($row['alamat']) ?></div>
                                <div>Metode Pembayaran: <?= htmlspecialchars($row['metode_pembayaran']) ?></div>
                                <div>Status: <span class="status <?= strtolower($row['status']) ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></span></div>
                            </div>
                        <!-- Menampilkan tombol batalkan pesanan jika status 'pending' -->
                        <?php if ($row['status'] == 'pending'): ?>
                            <form action="./proses/cancel_order.php" method="POST" style="margin-top: 10px;">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>">
                                <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                            </form>
                        <?php endif; ?>

                        <!-- Menambahkan tombol hapus pesanan -->
                        <form action="./proses/delete_order.php" method="POST" style="margin-top: 10px;">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>">
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus Pesanan</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Anda belum memiliki riwayat pesanan.</p>
            <?php endif; ?>
            </div>
        </body>
</html>
