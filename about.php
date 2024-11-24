<?php require_once "./config.php"; 
session_start(); // Pastikan session dimulai
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}


// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Toko Nurul SRC</title>
    <link rel="icon" href="assets/items/logo.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="assets/items/logo.png" alt="Logo Toko Nurul SRC" style="height: 50px;"> Nurul SRC
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="belanja.php">Belanja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="komentar.php">Komentar</a>
                        </li>
                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user"></i></i>
                                        <?= $_SESSION['username']; ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="./proses/akun_setting.php"><i class="fas fa-cog"></i> Pengaturan Akun</a></li>
                                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <!-- Bagian Tentang Kami -->
        <section class="py-5" style="background-color: #fdfdfd;">
            <h1 class="text-center" style="box-shadow: 0 3px #f57224; color: #f57224; padding: 10px;">Tentang Kami
            </h1>
            <p>
                Kami adalah toko e-commerce terpercaya yang berfokus pada penyediaan berbagai kebutuhan rumah tangga dengan mudah dan praktis. Berdiri pada akhir tahun 2021, kami hadir untuk memberikan pengalaman berbelanja yang nyaman, aman, dan terpercaya bagi setiap
                keluarga Indonesia. Kami mengerti bahwa kebutuhan harian yang lengkap dan berkualitas sangat penting untuk mendukung rutinitas Anda, mulai dari sembako, jajanan, minuman, hingga perlengkapan kebersihan seperti sabun dan bumbu dapur.
            </p>
            <p>
                Sejak awal, kami berkomitmen untuk menawarkan produk berkualitas dengan harga yang bersahabat. Kami percaya bahwa harga yang terjangkau tidak harus mengorbankan kualitas, itulah sebabnya kami selalu memastikan produk yang kami tawarkan segar, aman, dan
                memenuhi standar tinggi. Tim kami secara aktif bekerja dengan berbagai pemasok dan produsen lokal untuk memastikan produk kami selalu tersedia, dengan variasi yang cukup untuk memenuhi kebutuhan dan selera semua orang.
            </p>
            <p>
                Sebagai toko e-commerce yang terus berkembang, kepuasan Anda adalah prioritas utama kami. Kami menghadirkan layanan yang cepat dan pengiriman yang dapat diandalkan, sehingga Anda bisa mendapatkan barang kebutuhan dengan mudah, kapan pun dan di mana pun.
                Selain itu, kami selalu terbuka terhadap masukan dan saran dari pelanggan untuk meningkatkan layanan kami agar semakin sesuai dengan kebutuhan Anda.
            </p>
            <p>
                Terima kasih telah mempercayakan kami sebagai mitra belanja kebutuhan rumah tangga Anda. Kami berharap dapat terus melayani Anda dengan produk terbaik dan layanan yang memuaskan. Selamat berbelanja!
            </p>
        </section>
    </div>

    <script src="script/script.js"></script>
    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Toko Nurul SRC
                </h5>
                <p>Toko kelontong terpercaya yang menyediakan produk berkualitas dengan harga terjangkau. Temukan kebutuhan sehari-hari Anda di Toko Nurul SRC.</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Pembayaran</h5>
                <ul class="list-unstyled">
                    <li><img src="assets/items/visa.png" alt="Visa" width="60"></li>
                    <li><img src="assets/items/dana.png" alt="Dana" width="60"></li>
                    <li><img src="assets/items/pypal1.png" alt="Paypal" width="60"></li>
                    <li><img src="assets/items/gopay.png" alt="Gopay" width="60"></li>
                </ul>
            </div>

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Layanan Pelanggan
                </h5>
                <p><a href="contact.html" class style="text-decoration: none; color: #272727;">Hubungi
                            Kami</a></p>
                <p><a href="#" class style="text-decoration: none; color: #272727;">Pertanyaan
                            Umum</a></p>
                <p><a href="#" class style="text-decoration: none; color: #272727;">Kebijakan
                            Pengembalian</a></p>
                <p><a href="#" class style="text-decoration: none; color: #272727;">Kebijakan
                            Privasi</a></p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Ikuti Kami
                </h5>
                <ul class="list-unstyled">
                    <li><a href="#" class style="text-decoration: none; color: #272727;"><i
                                    class="fab fa-facebook fa-lg me-2"></i>Facebook</a></li>
                    <li><a href="#" class style="text-decoration: none; color: #272727;"><i
                                    class="fab fa-instagram fa-lg me-2"></i>Instagram</a></li>
                    <li><a href="#" class style="text-decoration: none; color: #272727;"><i
                                    class="fab fa-twitter fa-lg me-2"></i>Twitter</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Pengiriman</h5>
                <ul class="list-unstyled">
                    <li><img src="assets/items/jne.png" alt="JNE" width="90"></li>
                    <li><img src="assets/items/jnt.png" alt="J&T" width="90"></li>
                    <li><img src="assets/items/sicepat.png" alt="Sicepat" width="90"></li>
                    <li><img src="assets/items/ninjaexpress.png" alt="NinjaExpress" width="90"></li>
                </ul>
            </div>
        </div>

        <div class="row align-items-center" style="margin-bottom: 12px;">
            <div class="col-md-12 col-lg-12">
                <p class="text-center mt-4">&copy; 2024 Toko Nurul SRC. All Rights Reserved.</p>
            </div>
        </div>
        <div class="row align-items-center" style="margin-top: 20px;">
            <div class="col-md-12 col-lg-12 text-center">
                <p><strong>Lokasi Toko:</strong> <a href="https://maps.app.goo.gl/aEDsW4RV3VkzrGJX6" target="_blank" style="text-decoration: none; color: #272727;">Klik
                            di sini untuk melihat di Google Maps</a></p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/fontawesome-free-6.6.0-web/js/all.min.js"></script>
</body>

</html>