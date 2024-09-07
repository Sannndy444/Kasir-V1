<?php
require '../config/config.php';
session_start();

if(isset($_POST['submit']) && isset($_SESSION['users_id'])){
    $username = mysqli_real_escape_string($conn, $_POST['unameC']);
    $email = mysqli_real_escape_string($conn, $_POST['emailC']);
    $store_id = $_POST['store_id'];

    $sql = "INSERT INTO users (username, email, store_id, role) VALUES (?, ?, ?, 'kasir')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $username, $email, $store_id, $role);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo "<script>alert('Kasir berhasil ditambahkan.'); window.location.href = '../pages/addcashier-page.php';</script>";
        echo "Password untuk kasir ini adalah: " . $password_plain;
    } else {
        echo "<script>alert('Gagal menambahkan kasir.');</script>";
    }
} else {
    echo "<script>alert('anda perlu login untuk menambahkan kasir.');</script>";
}

// $password_plain = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
// $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

;