<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko_royal");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$bulan = date('m'); 
$tahun = date('Y');

$query = "
    SELECT 
        prodact.nama_barang,
        prodact.harga_awal,
        prodact.harga,
        SUM(order_details.quantity) AS quantity,
        SUM(order_details.quantity * prodact.harga_awal) AS total_harga_awal,
        SUM(order_details.quantity * prodact.harga) AS total_harga_jual,
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

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'Nama Barang');
$sheet->setCellValue('B1', 'Harga Awal');
$sheet->setCellValue('C1', 'Harga Jual');
$sheet->setCellValue('D1', 'Jumlah Terjual');
$sheet->setCellValue('E1', 'Total Harga Awal');
$sheet->setCellValue('F1', 'Total Harga Jual');
$sheet->setCellValue('G1', 'Laba');

// Menambahkan data laporan ke spreadsheet
$rowNum = 2; // Mulai dari baris kedua untuk data
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('B' . $rowNum, number_format($row['harga_awal'], 0, ',', '.'));
    $sheet->setCellValue('C' . $rowNum, number_format($row['harga'], 0, ',', '.'));
    $sheet->setCellValue('D' . $rowNum, $row['quantity']);
    $sheet->setCellValue('E' . $rowNum, number_format($row['total_harga_awal'], 0, ',', '.'));
    $sheet->setCellValue('F' . $rowNum, number_format($row['total_harga_jual'], 0, ',', '.'));
    $sheet->setCellValue('G' . $rowNum, number_format($row['laba'], 0, ',', '.'));
    $rowNum++;
}

// Menyimpan file Excel ke output
$writer = new Xlsx($spreadsheet);
$filename = 'laporan_keuangan_' . $bulan . '_' . $tahun . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

// Menutup koneksi database
$koneksi->close();
?>
