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
    <title>Tambah Akun Kasir</title>

    <!-- My style -->
    <style>
        :root {
            --primary: #E3E1D9;
            --bg: #F2EFE5;
            --third: #C7C8CC;
            --nav: #495464;
            --font: #424242;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Tambah Akun Kasir</h2>
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
                    <label for="passC">Password Kasir : </label>
                    <input type="password" name="passC" id="passC" required> <br>
                    <label for="conpassC">Konfirmasi Password : </label>
                    <input type="password" name="conpassC" id="conpassC" required> <br>
                    <input type="hidden" name="store_id" value="<?php echo $store_id ?>">
                    <button type="submit" name="submit" id="submit">Buat</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>