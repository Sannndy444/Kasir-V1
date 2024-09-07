<?php
require '../config/config.php';
session_start();

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
    <title>Tambah Kasir</title>
</head>
<body>
    <div class="container">
        <div class="judul">
            <h2>Tambah Kasir</h2>
        </div>
        <div class="link">
            <a href="stores-page.php">Kembali</a>
        </div>
        <hr>
        <div class="addcashier-form">
            <form action="../process/addcashier.php" method="post">
                <label for="unameC">Username Kasir : </label> 
                <input type="text" name="unameC" id="unameC" required> <br>
                <label for="emailC">Email Kasir : </label>
                <input type="email" name="emailC" id="emailC" required> <br>
                <input type="hidden" name="store_id" value="<?php echo $store_id ?>">
                <button type="submit" name="submit" id="submit">Tambah Kasir</button>
            </form>
        </div>
    </div>
</body>
</html>