<?php
// Memanggil file config untuk koneksi database
require '../config/config.php';

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login dengan memeriksa session
if(!empty($_SESSION["id"])){
    // Jika pengguna sudah login, redirect ke halaman dashboard atau halaman lain yang diinginkan
    header("Location: dashboard-page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Log In</h2>
        </div>
        <div class="login-form">
            <form action="../process/login.php" method="post">
                <label for="usermail">Username or Email : </label>
                <input type="text" name="usermail" id="usermail" require> <br>
                <label for="password">Passwsord : </label>
                <input type="password" name="password" id="password" require> <br>
                <button type="submit" name="login">Log In</button>
            </form>
            
        </div>
        <div class="extra">
            Dont have account? <a href="signup-page.php">Sign Up</a>
        </div>
    </div>
</body>
</html>