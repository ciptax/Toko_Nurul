<?php
include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

function getComments()
{
    global $conn;
    $sql = "SELECT ulasan.id, ulasan.user_id, users.nama, ulasan.komentar, ulasan.created_at FROM ulasan LEFT JOIN users ON ulasan.user_id = users.id ORDER BY ulasan.created_at DESC";
    $result = $conn->query($sql);

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            "id" => $row["id"],
            "user_id" => $row["user_id"],
            "nama" => $row["nama"],
            "komentar" => $row["komentar"]
        ];
    }

    return $comments;
}
// Ambil balasan komentar berdasarkan comment_id
function getReplies($comment_id)
{
    global $conn;
    $sql = "SELECT replies.id, replies.user_id, replies.reply_text, replies.created_at, users.nama 
            FROM replies 
            LEFT JOIN users ON replies.user_id = users.id 
            WHERE replies.comment_id = {$comment_id} 
            ORDER BY replies.created_at ASC";
    $result = $conn->query($sql);

    $replies = [];
    while ($row = $result->fetch_assoc()) {
        $replies[] = [
            "id" => $row["id"],
            "user_id" => $row["user_id"],
            "nama" => $row["nama"],
            "reply_text" => $row["reply_text"],
            "created_at" => $row["created_at"],
        ];
    }
    return $replies;
}

// Simpan balasan baru
function addReply($comment_id, $reply_text)
{
    global $conn, $user_id;
    $sql = "INSERT INTO replies (comment_id, user_id, reply_text) 
            VALUES ({$comment_id}, {$user_id}, '{$reply_text}')";
    return $conn->query($sql);
}

function inputComment($comment)
{
    global $conn, $user_id;
    $sql = "INSERT INTO ulasan(user_id, komentar) VALUES ({$user_id}, '{$comment}')";

    if ($conn->query($sql)) {
        header("Location: komentar.php");
    }
}

getComments();
?>