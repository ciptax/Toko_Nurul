<?php
$koneksi = new mysqli("localhost", "root", "", "toko_royal");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses konfirmasi pesanan
if (isset($_GET['konfirmasi'])) {
    $order_id = $_GET['konfirmasi'];

    // Update status pesanan menjadi "confirmed"
    $update_status = "UPDATE orders SET status = 'confirmed' WHERE order_id = $order_id";
    $koneksi->query($update_status);

    // Setelah mengkonfirmasi, alihkan halaman untuk menghindari pengulangan tindakan
    header("Location: laporan_penjualan.php");
    exit();
}

// Proses pembatalan pesanan
if (isset($_GET['batal'])) {
    $order_id = $_GET['batal'];

    // Update status pesanan menjadi "batal"
    $update_status = "UPDATE orders SET status = 'batal' WHERE order_id = $order_id";
    $koneksi->query($update_status);

    // Setelah membatalkan, alihkan halaman untuk menghindari pengulangan tindakan
    header("Location: laporan_penjualan.php");
    exit();
}

// Query untuk mendapatkan data penjualan
$query = "
    SELECT 
        orders.order_id, 
        orders.order_date, 
        orders.status,
        users.nama AS customer_name,
        order_details.product_id,
        prodact.nama_barang,
        order_details.quantity,
        prodact.harga,
        (order_details.quantity * prodact.harga) AS total_harga
    FROM 
        order_details
    JOIN 
        orders ON order_details.order_id = orders.order_id
    JOIN 
        users ON orders.user_id = users.id
    JOIN 
        prodact ON order_details.product_id = prodact.id
    ORDER BY 
        orders.order_date DESC
";

$result = $koneksi->query($query);

// Query untuk menghitung total penjualan
$total_query = "
    SELECT SUM(order_details.quantity * prodact.harga) AS total_penjualan
    FROM 
        order_details
    JOIN 
        prodact ON order_details.product_id = prodact.id
";

$total_result = $koneksi->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_penjualan = $total_row['total_penjualan'] ?? 0; // Jika nilai total_penjualan null, set ke 0
$total_penjualan_format = number_format($total_penjualan, 0, ',', '.'); // Formatkan dengan number_format
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
</head>
<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
}

h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 10px;
}

h3 {
    text-align: center;
    font-size: 24px;
    color: #16a085;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
}

table thead {
    background-color: #f57224;
    color: white;
    text-align: left;
}

table th, table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

table tbody tr:hover {
    background-color: #f1f1f1;
}

a {
    color: white;
    text-decoration: none;
}

.button {
    display: inline-block;
    padding: 10px 15px;
    font-size: 14px;
    text-align: center;
    color: white;
    background-color: #f57224;
    border-radius: 5px;
    transition: 0.3s;
}

.button:hover {
    background-color: #13896b;
}

.button.disabled {
    background-color: #bdc3c7;
    cursor: not-allowed;
}

tfoot th {
    font-size: 16px;
    font-weight: bold;
    text-align: right;
    padding: 15px;
    background-color: #f4f4f4;
}

</style>
<body>
    <h2>Laporan Penjualan</h2>

    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal Pesanan</th>
                <th>Nama Customer</th>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>" . $row['customer_name'] . "</td>";
                    echo "<td>" . $row['product_id'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . ($row['status'] === 'confirmed' ? 'Terkonfirmasi' : ($row['status'] === 'batal' ? 'Pesanan Dibatalkan' : 'Belum Dikonfirmasi')) . "</td>";
                    
                    // Jika status pesanan 'belum dikonfirmasi' atau 'terkonfirmasi', tampilkan tombol konfirmasi atau batal
                    if ($row['status'] !== 'confirmed' && $row['status'] !== 'batal') {
                        echo "<td><a href='?konfirmasi=" . $row['order_id'] . "' class='button' onclick='return confirm(\"Yakin ingin mengonfirmasi pesanan ini?\")'>Konfirmasi</a></td>";
                    } else if ($row['status'] === 'confirmed') {
                        echo "<td><span class='button disabled'>Terkonfirmasi</span></td>";
                    }

                    // Menambahkan tombol untuk membatalkan pesanan jika status belum dikonfirmasi
                    if ($row['status'] !== 'batal' && $row['status'] !== 'confirmed') {
                    } else if ($row['status'] === 'batal') {
                        echo "<td><span class='button disabled'>Pesanan Dibatalkan</span></td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Tidak ada data penjualan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$koneksi->close();
?>