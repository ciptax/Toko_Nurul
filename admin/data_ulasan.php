<?php
session_start();
require '../config.php';

// Pastikan admin yang login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan data ulasan
$query = "
    SELECT u.id AS ulasan_id, u.komentar, u.created_at, u.user_id, us.nama AS user_nama
    FROM ulasan u
    JOIN users us ON u.user_id = us.id
    ORDER BY u.created_at DESC
";
$result = mysqli_query($conn, $query);

// Query untuk mendapatkan data balasan
$replies_query = "
    SELECT r.id AS reply_id, r.comment_id, r.reply_text, r.created_at, us.nama AS user_nama
    FROM replies r
    JOIN users us ON r.user_id = us.id
    ORDER BY r.created_at ASC
";
$replies_result = mysqli_query($conn, $replies_query);

$replies = [];
while ($reply = mysqli_fetch_assoc($replies_result)) {
    $replies[$reply['comment_id']][] = $reply;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    /* Body Styles */
body {
    background: linear-gradient(to bottom, #f5f5f5, #eaeaea);
    font-family: 'Poppins', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
}

/* Card Styles */
.card {
    border: none;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

/* Card Header */
.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #f57224;
}

/* Text Styles */
.card-text {
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 10px;
    color: #555;
}

.text-muted {
    font-size: 0.9rem;
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-size: 0.9rem;
    padding: 8px 15px;
    transition: all 0.3s ease;
}

.btn-danger {
    background-color: #ff6b6b;
    border: none;
    color: #fff;
}

.btn-danger:hover {
    background-color: #e05454;
    box-shadow: 0 4px 10px rgba(255, 107, 107, 0.5);
}

.btn-primary {
    background-color: #f57224;
    border: none;
    color: #fff;
}

.btn-primary:hover {
    background-color: #d65e20;
    box-shadow: 0 4px 10px rgba(245, 114, 36, 0.5);
}

/* Replies */
.card .card-body .card {
    background: #f9f9f9;
    border: 1px solid #eaeaea;
}

.card .card-body .card h6 {
    color: #f57224;
    font-weight: bold;
}

.card .card-body .card p {
    font-size: 0.9rem;
    color: #666;
}

/* Modal */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background-color: #f57224;
    color: #fff;
    border-radius: 15px 15px 0 0;
    padding: 20px;
    border-bottom: none;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.modal-body {
    padding: 20px;
    background: #fafafa;
}

.modal-footer {
    border-top: none;
    padding: 15px 20px;
    background: #f9f9f9;
}

textarea {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 0.9rem;
    width: 100%;
}

textarea:focus {
    border-color: #f57224;
    box-shadow: 0 0 8px rgba(245, 114, 36, 0.3);
    outline: none;
}

/* Animations */
.card {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .card-title {
        font-size: 1rem;
    }

    .btn {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
}

</style>
<body>
<div class="container mt-5">
    <h1>Data Ulasan</h1>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['user_nama']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($row['komentar']) ?></p>
                <p class="text-muted small">Dibuat pada: <?= $row['created_at'] ?></p>
                
                <!-- Tombol Hapus dan Balas Ulasan -->
                <div class="d-flex">
                    <a href="delete_comment.php?id=<?= $row['ulasan_id'] ?>" class="btn btn-danger btn-sm me-2">Hapus</a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal" data-id="<?= $row['ulasan_id'] ?>">Balas</button>
                </div>

                <!-- Tampilkan Balasan -->
                <?php if (isset($replies[$row['ulasan_id']])) { ?>
                    <div class="mt-3">
                        <strong>Balasan:</strong>
                        <?php foreach ($replies[$row['ulasan_id']] as $reply) { ?>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h6><?= htmlspecialchars($reply['user_nama']) ?></h6>
                                    <p><?= htmlspecialchars($reply['reply_text']) ?></p>
                                    <p class="text-muted small">Dibalas pada: <?= $reply['created_at'] ?></p>
                                    <a href="delete_reply.php?id=<?= $reply['reply_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Modal Balas -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_reply.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Balas Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="comment_id" id="commentId">
                    <div class="mb-3">
                        <label for="replyText" class="form-label">Balasan</label>
                        <textarea class="form-control" id="replyText" name="reply_text" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const commentId = button.getAttribute('data-id');
        const inputCommentId = replyModal.querySelector('#commentId');
        inputCommentId.value = commentId;
    });
</script>
</body>
</html>
