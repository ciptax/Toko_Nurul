<?php
session_start();
include "../config.php";

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Inisialisasi pesan
$successMessage = '';
$errorMessage = '';

// Tambah kategori baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_category'])) {
    $newCategory = strtoupper(trim($_POST['new_category']));
    $currentEnums = getCategoriesEnum();

    // Cek apakah kategori sudah ada
    if (in_array($newCategory, $currentEnums)) {
        $errorMessage = "Kategori '$newCategory' sudah ada.";
    } else {
        // Tambahkan kategori ke enum
        $currentEnums[] = $newCategory;
        if (updateEnumColumn($currentEnums)) {
            $successMessage = "Kategori '$newCategory' berhasil ditambahkan.";
        } else {
            $errorMessage = "Gagal menambahkan kategori.";
        }
    }
}

// Hapus kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $deleteCategory = strtoupper(trim($_POST['delete_category']));
    $currentEnums = getCategoriesEnum();

    // Cek apakah kategori ada
    if (!in_array($deleteCategory, $currentEnums)) {
        $errorMessage = "Kategori '$deleteCategory' tidak ditemukan.";
    } else {
        // Hapus kategori dari enum
        $currentEnums = array_diff($currentEnums, [$deleteCategory]);
        if (updateEnumColumn($currentEnums)) {
            $successMessage = "Kategori '$deleteCategory' berhasil dihapus.";
        } else {
            $errorMessage = "Gagal menghapus kategori.";
        }
    }
}

// Ambil daftar kategori
$categories = getCategoriesEnum();

// Fungsi untuk mendapatkan kategori dari enum
function getCategoriesEnum() {
    global $conn;
    $query = "SHOW COLUMNS FROM prodact LIKE 'kategori'";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
        return str_getcsv($matches[1], ',', "'");
    }
    return [];
}

// Fungsi untuk memperbarui kolom enum kategori
function updateEnumColumn($categories) {
    global $conn;
    $newEnumValues = implode("','", $categories);
    $alterQuery = "ALTER TABLE prodact MODIFY COLUMN kategori ENUM('$newEnumValues') NOT NULL";
    return $conn->query($alterQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - Royal Sejahtera</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Daftar Kategori Produk</h2>

    <!-- Tampilkan pesan sukses atau error -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success" role="alert">
            <?= $successMessage ?>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $index => $category): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($category) ?></td>
                    <td>
                        <!-- Form hapus kategori -->
                        <form method="POST" action="data_kategori.php" style="display:inline;">
                            <input type="hidden" name="delete_category" value="<?= $category ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Form untuk menambah kategori baru -->
    <div class="mt-4">
        <h4>Tambah Kategori Baru</h4>
        <form method="POST" action="data_kategori.php">
            <div class="form-group">
                <label for="new_category">Nama Kategori Baru</label>
                <input type="text" class="form-control" id="new_category" name="new_category" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kategori</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
