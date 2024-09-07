<?php
require '../config/config.php';
session_start();

// Memeriksa apakah pengguna memiliki akses ke halaman ini dan merupakan admin
if ($_SESSION["role"] !== 'admin') {
    echo "<script>alert('Access denied.'); window.location.href = '../pages/stores-page.php';</script>";
    exit;
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Tambah Barang</h2>
        </div>
        <div class="link">
            <a href="stores-page.php">Kembali</a>
        </div>
        <hr>
        <div class="addproduct-form">
            <form action="../process/addproducts.php" method="post" enctype="multipart/form-data">
                <label for="pname">Nama Barang : </label>
                <input type="text" name="pname" id="pname" required> <br>
                <label for="price">Harga Barang : </label>
                <input type="number" name="price" id="price" required> <br>
                <label for="stock">Stok Barang : </label>
                <input type="number" name="stock" id="stock"> <br>
                <label for="img">Upload Gambar : </label> 
                <input type="file" name="img" id="img" required>
                <input type="hidden" name="stores_id" value="<?php echo $_SESSION['store_id'];?>">
                <button type="submit" name="submit">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>