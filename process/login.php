<?php
require '../config/config.php';
session_start();

if(isset($_POST['login'])){
    $usermail = mysqli_real_escape_string($conn,$_POST["usermail"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    
    // Query untuk mengambil data user berdasarkan username atau email
    $query = "SELECT users_id, password,role FROM users WHERE username = '$usermail' OR email = '$usermail'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_pass = $row['password'];

        if(password_verify($password, $hashed_pass)){
            $_SESSION['users_id'] = $row['users_id'];
            $_SESSION['role'] = $row['role'];

            $user_id = $_SESSION['users_id'];
            $store_query = "SELECT store_id FROM stores WHERE owner_id = '$user_id'";
            $store_result = mysqli_query($conn, $store_query);

            if(mysqli_num_rows($store_result) > 0) {
                $store_row = mysqli_fetch_assoc($store_result);
                $_SESSION['store_id'] = $store_row['store_id'];
            } else {
                $_SESSION['store_id'] = null;
            }

            header("Location: ../pages/dashboard-page.php");  // Arahkan user setelah login
            exit;
        } else {
            echo "<script>alert('Password salah.'); window.location.href = '../pages/login-page.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan.'); window.location.href = '../pages/login-page.php';</script>";
    }
}