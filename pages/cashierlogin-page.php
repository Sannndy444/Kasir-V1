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
    <title>Kasir Login</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Kasir Login</h2>
        </div>
        <hr>
        <div class="cashier-form">
            <label for="usermail">Username or Email : </label>
            <input type="text" name="usermail" id="usermail" required> <br>
            <label for="pass">Password : </label>
            <input type="password" name="pass" id="pass" required> <br>
            <button type="login" name="login" id="login" required>Login</button>
        </div>
        <div class="extra">
            <a href="signup-page.php">Sign Up</a>
            Already have store? <a href="login-page.php">Cashier Login</a>
        </div>
    </div>
</body>
</html>