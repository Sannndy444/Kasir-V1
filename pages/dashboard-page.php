<?php
// Mulai sesi PHP
session_start();

// Memanggil file config untuk koneksi database
require '../config/config.php';

// Memeriksa apakah pengguna sudah login dengan memeriksa session ID
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    
    // Melakukan query untuk mendapatkan data pengguna berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    
    // Memeriksa apakah query berhasil dan ada data yang diambil
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Jika query gagal atau tidak ada data, redirect ke halaman login
        header("Location: login-page.php");
        exit;
    }
} else {
    // Jika session ID tidak ada, redirect ke halaman login
    header("Location: login-page.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to Dashboard, <?php echo $row['username']; ?></h2> <br>
    <a href="../process/logout.php">Log Out</a>
</body>
</html>