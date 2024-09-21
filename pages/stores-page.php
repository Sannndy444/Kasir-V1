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

        body {
            font-family: 'Poppins';
            color: #fff;
            background-color: var(--bg);
            overflow-x: hidden;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        .deskripsi {
            margin-bottom: 20px;
        }

        .deskripsi a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: var(--nav);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .deskripsi a:hover {
            background-color: var(--font);
        }

        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <?php include 'sidebar.php' ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Store Page</h2>
            </div>
            <div class="deskripsi">
                <a href="addproducts-page.php">Tambah Product</a>
                <a href="addcashier-page.php">Tambah Kasir</a>
            </div>
            <hr>
            <div class="viewstore">
                <?php include 'product-page.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>