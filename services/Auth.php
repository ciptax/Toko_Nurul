<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php'; // Pastikan file koneksi database sudah benar

function register($nama, $username, $password, $role, $alamat, $nomor_hp): bool
{
    global $conn;

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Escape input untuk mencegah SQL injection
    $nama = $conn->real_escape_string($nama);
    $username = $conn->real_escape_string($username);
    $passwordHash = $conn->real_escape_string($passwordHash);
    $role = $conn->real_escape_string($role);
    $alamat = $conn->real_escape_string($alamat);
    $nomor_hp = $conn->real_escape_string($nomor_hp);

    // Cek apakah username sudah ada
    $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        echo "Username sudah terdaftar. Silakan gunakan username lain.";
        return false;
    }

    // Menyusun query dengan nilai yang sudah di-escape
    $sql = "INSERT INTO users (nama, username, password, role, alamat, nomor_hp) 
            VALUES ('$nama', '$username', '$passwordHash', '$role', '$alamat', '$nomor_hp')";

    // Eksekusi query
    if ($conn->query($sql)) {
        return true;
    } else {
        echo "Registrasi gagal: " . $conn->error;
        return false;
    }
}

function login($username, $password): bool
{
    global $conn;

    // Escape input untuk mencegah SQL injection
    $username = $conn->real_escape_string($username);

    // Query untuk mengambil password hash berdasarkan username
    $sql = "SELECT id, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    // Jika user ditemukan
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];
        // Verifikasi password
        if (password_verify($password, $hashedPassword)) {
            // Login berhasil, simpan data ke sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            return true;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    // Login gagal 
    return false;
}

function checkLogin()
{
    if (!empty($_SESSION['username']) && !empty($_SESSION['role'])) {
        if ($_SESSION['role'] === "customer") {
            header("Location: belanja.php");
        } elseif ($_SESSION['role'] === "admin") {
            header("Location: admin");
        }
        exit();
    }
}
