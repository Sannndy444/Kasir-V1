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
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="judul">
        <h2>Registration</h2>
        </div>
        
        <div class="form-singup">
            <form action="../process/signup.php" method="post">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required > <br>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" required > <br>
                <label for="pass">Password : </label>
                <input type="password" name="pass" id="pass" required > <br>
                <label for="confpass">Confirm Password : </label>
                <input type="password" name="confpass" id="confpass" required> <br>
                <select name="user_role" id="user_role">
                    <option value="kasir">User</option>
                    <option value="admin">Admin Toko</option>
                </select>
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
        <div class="extra">
            Already have account? <a href="login-page.php">Log In</a>
        </div>
    </div>
</body>
</html>