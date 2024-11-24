<?php 
session_start();
include "../config.php"; 

// Periksa apakah user sudah login dan memiliki akses sebagai admin
if (isset($_SESSION['username']) && $_SESSION['role'] === "admin") {
    // Ambil data users dengan role customer
    $query = "SELECT id, nama, username, alamat, nomor_hp FROM users WHERE role = 'customer'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customers - Royal Sejahtera</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Warna dan desain */
        body {
            background-color: #f7f8fa;
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #f57224;
            font-weight: bold;
        }
        .btn-edit {
            background-color: #f57224;
            color: white;
        }
        .btn-edit:hover {
            background-color: #d4601e;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="table-container">
            <h2 class="text-center mb-4">Data Customers</h2>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Nomor HP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['nomor_hp']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
