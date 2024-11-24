<?php
include '../config.php'; // Koneksi ke database

// Cek jika ada parameter id yang diterima melalui URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Pastikan id adalah integer untuk keamanan

    // Ambil data produk dari database
    $sql = "SELECT * FROM prodact WHERE id = $id";
    $result = $conn->query($sql);

    // Jika data produk ditemukan
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit();
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $harga_awal = $_POST['harga_awal']; // Menangkap harga awal

    // Jika gambar baru diupload
    $gambar = $row['gambar']; // Gambar lama
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $targetDir = "../assets/";
        $newFileName = time() . '_' . basename($_FILES['gambar']['name']); // Buat nama file unik
        $targetFile = $targetDir . $newFileName;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = $newFileName; // Hanya simpan nama file di database
        } else {
            echo "Gagal mengupload gambar.";
            exit();
        }
    }

    // Update data produk ke database, termasuk `harga_awal`
    $sql = "UPDATE prodact SET 
                nama_barang = '$nama_barang', 
                harga = '$harga', 
                stok = '$stok', 
                gambar = '$gambar', 
                deskripsi = '$deskripsi', 
                kategori = '$kategori',
                harga_awal = '$harga_awal'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: data_produk.php"); // Redirect ke halaman produk
        exit();
    } else {
        echo "Gagal mengubah produk: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk</title>
    <link rel="icon" href="assets/items/logo.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Ubah Produk</h2>
        <form action="ubah_produk.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_barang">Nama Produk</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($row['nama_barang']); ?>" required>
            </div>
            <div class="form-group">
    <label for="harga_awal">Harga Awal</label>
    <input type="number" class="form-control" id="harga_awal" name="harga_awal" value="<?= htmlspecialchars($row['harga_awal']); ?>" required>
</div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= htmlspecialchars($row['harga']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?= htmlspecialchars($row['stok']); ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($row['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="SEMBAKO" <?= $row['kategori'] == 'SEMBAKO' ? 'selected' : ''; ?>>SEMBAKO</option>
                    <option value="JAJANAN" <?= $row['kategori'] == 'JAJANAN' ? 'selected' : ''; ?>>JAJANAN</option>
                    <option value="SABUN" <?= $row['kategori'] == 'SABUN' ? 'selected' : ''; ?>>SABUN</option>
                    <option value="MINUMAN" <?= $row['kategori'] == 'MINUMAN' ? 'selected' : ''; ?>>MINUMAN</option>
                    <option value="BUMBU DAPUR" <?= $row['kategori'] == 'BUMBU DAPUR' ? 'selected' : ''; ?>>BUMBU DAPUR</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
