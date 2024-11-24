<?php
include "../config.php"; // Pastikan ini terhubung dengan konfigurasi database

// Proses form saat tombol submit ditekan
// Proses form saat tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $harga_awal = $_POST['harga_awal'];  // Ambil harga awal dari input form
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Proses upload gambar
    $targetDir = "../assets/"; // Direktori tempat menyimpan gambar
    $fileName = basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validasi format file
    $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array(strtolower($fileType), $allowedTypes)) {
        // Upload file ke server
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
            // Simpan data produk ke database dengan harga awal
            $sql = "INSERT INTO prodact (nama_barang, harga, harga_awal, stok, gambar, deskripsi, kategori) 
                    VALUES ('$nama_barang', $harga, $harga_awal, $stok, '$fileName', '$deskripsi', '$kategori')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p class='alert alert-success'>Produk berhasil ditambahkan.</p>";
            } else {
                echo "<p class='alert alert-danger'>Terjadi kesalahan saat menyimpan data: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Gagal mengunggah gambar.</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Format gambar tidak valid. Hanya diperbolehkan JPG, JPEG, PNG, dan GIF.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="icon" href="assets/items/logo.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h2 class="text-center mb-4">Tambah Produk Baru</h2>
        <form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label for="harga_awal">Harga Awal</label>
                <input type="number" class="form-control" id="harga_awal" name="harga_awal" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok Barang</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="SEMBAKO">SEMBAKO</option>
                    <option value="JAJANAN">JAJANAN</option>
                    <option value="SABUN">SABUN</option>
                    <option value="MINUMAN">MINUMAN</option>
                    <option value="BUMBU DAPUR">BUMBU DAPUR</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
