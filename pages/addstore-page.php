<?php
require '../config/config.php';
session_start();

// Memeriksa apakah pengguna memiliki akses ke halaman ini
if ($_SESSION["role"] !== 'admin') {
    echo "<script>alert('Access denied.');</script>";
    header("Location: ../pages/dashboard-page.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Store</title>

    <!-- My style -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Buat Toko</h2>
        </div>
        <div class="addstore-form">
            <form action="../process/addstore.php" method="post">
                <label for="ntoko">Nama Toko : </label>
                <input type="text" name="ntoko" id="ntoko" required> <br>
                <button type="submit" name="submit">Buat</button>
            </form>
        </div>
    </div>
</body>
</html>