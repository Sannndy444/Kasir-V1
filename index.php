<?php
// Memanggil file config untuk koneksi database
require 'config/config.php';

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login dengan memeriksa session
if(!empty($_SESSION["id"])){
    // Jika pengguna sudah login, redirect ke halaman dashboard atau halaman lain yang diinginkan
    header("Location: pages/dashboard-page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Simpel</title>
</head>
<body>
    <div class="container">
        <div class="nav">
            
        </div>
        <div class="head">
            <h2>
                Welcome To Kasir Simple App
            </h2>
        </div>
        
    </div>
</body>
</html>