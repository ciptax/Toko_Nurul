<?php
include '../config.php';
session_start();

if (isset($_GET['id'])) {
    $reply_id = $_GET['id'];

    // Ambil data balasan yang ingin diedit
    $sql = "SELECT * FROM replies WHERE id = $reply_id AND user_id = {$_SESSION['user_id']}";
    $result = $conn->query($sql);
    $reply = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_reply_text = $_POST['reply_text'];

        // Update balasan di database
        $update_sql = "UPDATE replies SET reply_text = '$new_reply_text' WHERE id = $reply_id";
        if ($conn->query($update_sql)) {
            header('Location: ../komentar.php');  // Redirect setelah update
        }
    }
} else {
    echo "Balasan tidak ditemukan.";
}
?>
<form method="post">
    <label for="reply_text">Edit Balasan:</label>
    <textarea id="reply_text" name="reply_text" required><?= $reply['reply_text'] ?></textarea>
    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
</form>
