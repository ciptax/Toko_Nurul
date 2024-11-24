<?php
// Koneksi ke database
    include 'config.php';
    include './comment.php';

    $datas = getComments();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $komentar = $_POST['komentar'];
        if (empty($komentar)) {
            ?> <script>alert("Komentar tidak boleh kosong !");</script> <?php

        } else {
            inputComment($komentar);
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ulasan Toko Nurul SRC</title>
        <link rel="icon" href="assets/items/logo.png" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="./assets/fontawesome-free-6.6.0-web/css/all.min.css">
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <style>
        /* Form Styling */
        .komentar-box {
            width: 100%;
            max-width: 45rem;
            border: 2px solid #f57224;
            border-radius: 8px;
            padding: 23px;
            font-size: 1rem;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .komentar-box:focus {
            border-color: #ffdb00;
            box-shadow: 0px 4px 12px rgba(255, 219, 0, 0.6);
            outline: none;
        }

        .btn-submit {
            background-color: #ffdb00;
            color: #000;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #f57224;
            color: #fff;
            transform: scale(1.05);
        }

        /* Card Styling */
        .komentar-card {
            width: 100%;
            max-width: 27rem;
            margin-bottom: 35px;
            border: 1px solid #f57224;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .komentar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #f57224;
            margin-bottom: 8px;
        }

        .card-title .fas {
            margin-right: 8px;
            color: #f57224;
            font-size: 1.5rem;
        }

        .card-title .user-icon {
            margin-left: auto;
            color: #ffdb00;
            font-size: 1.2rem;
        }

        .card-text {
            color: #333;
            font-size: 1rem;
            line-height: 1.5;
        }
        .btn-warning {
    background-color: #ffc107;
    color: #000;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9rem;
}

.btn-warning:hover {
    background-color: #e0a800;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9rem;
}

.btn-danger:hover {
    background-color: #bd2130;
}

    </style>

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
                                <a class="nav-link" href="belanja.php">Belanja</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html">About
                                    Us</a>
                            </li>
                            <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i></i> <?= $_SESSION['username']; ?>
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

        <div class="container mt-5">
            <form method="post">
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar</label>
                    <textarea class="form-control komentar-box" id="komentar" name="komentar" rows="4" placeholder="Tulis komentar Anda di sini" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Kirim Komentar</button>
            </form>
            <h5 class="card-title mt-3" style="margin-bottom: 16px; color: #f57224;">Semua Komentar</h5>
            <?php foreach ($datas as $data) { ?>
                <div class="card komentar-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="fas fa-user-circle"></span>
                            <?= $data['nama'] ?>
                            <span class="fas fa-comment-alt user-icon"></span>
                        </h5>
                        <p class="card-text"><?= $data['komentar'] ?></p>

                        <!-- Tombol Edit dan Hapus (hanya untuk pemilik komentar) -->
                        <?php if ($data['user_id'] == $_SESSION['user_id']) { ?>
                            <a href="./proses/edit_comment.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="./proses/delete_comment.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus komentar ini?')">Hapus</a>
                        <?php } ?>

                        <!-- Form Balas Komentar -->
                        <form method="post" action="./proses/reply_comment.php" class="mt-3">
                            <input type="hidden" name="comment_id" value="<?= $data['id'] ?>">
                            <textarea name="reply_text" rows="2" class="form-control mb-2" placeholder="Tulis balasan Anda di sini..." required></textarea>
                            <button type="submit" class="btn btn-primary btn-sm">Balas</button>
                        </form>

                        <!-- Tampilkan Balasan -->
                        <?php 
                            $replies = getReplies($data['id']);
                            foreach ($replies as $reply) { ?>
                            <div class="mt-3 ms-4 border-start ps-3">
                                <p><strong><?= $reply['nama'] ?></strong>: <?= $reply['reply_text'] ?></p>
                                <!-- Tombol Edit dan Hapus Balasan (hanya untuk pemilik balasan) -->
                                <?php if ($reply['user_id'] == $_SESSION['user_id']) { ?>
                                    <a href="./proses/edit_reply.php?id=<?= $reply['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="./proses/delete_reply.php?id=<?= $reply['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus balasan ini?')">Hapus</a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/fontawesome-free-6.6.0-web/js/all.min.js"></script>
    </body>

    </html>