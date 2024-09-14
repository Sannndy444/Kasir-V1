<?php
session_start();

if (!isset($_SESSION['store_id'])) {
    echo "<script>alert('Tidak ada toko yang dipilih. Silakan pilih atau buat toko terlebih dahulu.'); window.location.href = '../pages/dashboard-page.php';</script>";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Dashboard Toko</h2>
        </div>
        <div class="deskripsi">
            <a href="addproducts-page.php">Tambah Product</a>
            <a href="addcashier-page.php">Tambah Kasir</a>
            <a href="../process/logout.php">Log Out</a>
        </div>
        <hr>
        <div class="viewstore">
            <?php include 'product-page.php'; ?>
        </div>
    </div>
</body>
</html>