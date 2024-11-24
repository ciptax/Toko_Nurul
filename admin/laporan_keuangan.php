<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko_royal");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk menghitung laporan keuangan bulanan
$bulan = date('m'); // Bulan saat ini
$tahun = date('Y'); // Tahun saat ini

$query = "
    SELECT 
        prodact.id AS product_id,
        prodact.nama_barang,
        prodact.harga_awal,
        SUM(order_details.quantity) AS quantity,
        prodact.harga AS harga_jual,
        SUM(order_details.quantity * prodact.harga) AS total_harga_jual,
        SUM(order_details.quantity * prodact.harga_awal) AS total_harga_awal,
        (SUM(order_details.quantity * prodact.harga) - SUM(order_details.quantity * prodact.harga_awal)) AS laba
    FROM 
        order_details
    JOIN 
        orders ON order_details.order_id = orders.order_id
    JOIN 
        prodact ON order_details.product_id = prodact.id
    WHERE
        MONTH(orders.order_date) = $bulan AND YEAR(orders.order_date) = $tahun
    GROUP BY 
        prodact.id
";

$result = $koneksi->query($query);

// Inisialisasi total laba
$total_laba = 0;

// Kosongkan laporan keuangan
if (isset($_POST['kosongkan'])) {
    $deleteQuery = "
        DELETE order_details
        FROM order_details
        JOIN orders ON order_details.order_id = orders.order_id
        WHERE MONTH(orders.order_date) = $bulan AND YEAR(orders.order_date) = $tahun
    ";

    if ($koneksi->query($deleteQuery)) {
        echo "<script>alert('Laporan keuangan bulan ini berhasil dikosongkan.'); window.location.href='laporan_keuangan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengosongkan laporan keuangan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Bulanan</title>
    <link href="assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<style>
    /* Global Reset */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header Title */
.header-title {
    font-size: 28px;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 10px;
}

.subheader {
    font-size: 18px;
    color: #6c757d;
    margin-bottom: 20px;
}

/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th, .table td {
    text-align: center;
    border: 1px solid #dee2e6;
    padding: 12px;
    vertical-align: middle;
}

.table thead th {
    background-color: #f57224;
    color: #fff;
    font-weight: bold;
}

.table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.table tbody tr:nth-child(even) {
    background-color: #ffffff;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table tfoot th {
    background-color: #f4f4f4;
    font-weight: bold;
    color: #333;
    text-align: right;
    padding: 15px;
    border-top: 2px solid #dee2e6;
}

.table tfoot th:last-child {
    text-align: center;
    color: #28a745;
    font-size: 16px;
}

/* Buttons Styling */
.btn {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    transition: all 0.3s ease;
}

.btn-custom {
    background-color: #007bff;
    color: #fff;
}

.btn-custom:hover {
    background-color: #0056b3;
}

.btn-clear {
    background-color: #dc3545;
    color: #fff;
}

.btn-clear:hover {
    background-color: #c82333;
}

.btn-download {
    background-color: #28a745;
    color: #fff;
}

.btn-download:hover {
    background-color: #218838;
}

/* Button Group */
.d-flex {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.d-flex form {
    display: inline-block;
}

</style>
<div class="container">
    <h2 class="header-title text-center">Laporan Keuangan Bulanan - Toko Nurul SRC</h2>
    <h4 class="subheader text-center">Bulan: <?php echo date("F Y"); ?></h4>

    <!-- Tabel Laporan Keuangan -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Awal</th>
                    <th>Harga Jual</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Harga Awal</th>
                    <th>Total Harga Jual</th>
                    <th>Laba</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . number_format($row['harga_awal'], 0, ',', '.') . "</td>";
                    echo "<td>" . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . number_format($row['total_harga_awal'], 0, ',', '.') . "</td>";
                    echo "<td>" . number_format($row['total_harga_jual'], 0, ',', '.') . "</td>";
                    echo "<td>" . number_format($row['laba'], 0, ',', '.') . "</td>";
                    echo "</tr>";

                    // Tambahkan laba produk ke total laba
                    $total_laba += $row['laba'];
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data untuk bulan ini.</td></tr>";
            }
            ?>
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="6" class="text-right">Total Pendapatan</th>
                    <th><?= number_format($total_laba, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Tombol untuk Mengunduh Laporan dalam Excel dan Mengosongkan Laporan -->
    <div class="d-flex justify-content-center">
        <form action="export_excel.php" method="post">
            <button type="submit" class="btn btn-custom btn-download">
                <i class="fas fa-file-excel"></i> Unduh Laporan
            </button>
        </form>

        <form action="laporan_keuangan.php" method="post">
            <button type="submit" name="kosongkan" class="btn btn-custom btn-clear">
                <i class="fas fa-trash-alt"></i> Kosongkan Laporan
            </button>
        </form>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Menutup koneksi ke database
$koneksi->close();
?>
