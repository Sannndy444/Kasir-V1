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

        body {
            font-family: 'Poppins';
            color: var(--font);
            background-color: var(--bg);
            overflow-x: hidden;
            padding: 2rem 0 0 5rem;
        }

        .ca-container {
            display: flex;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background: var(--primary);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 20px; /* Space between sidebar and content */
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
            color: var(--font);
        }

        .link {
            margin-bottom: 20px;
        }

        .link button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            padding: 1rem 1rem 1rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s;
        }

        .addcashier-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .addcashier-form label {
            display: block;
            margin: 10px 0 5px;
            color: var(--font);
        }

        .addcashier-form input[type="text"],
        .addcashier-form input[type="email"],
        .addcashier-form input[type="password"],
        .addcashier-form input[type="conpassC"],
        .addcashier-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .addcashier-form button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .addcashier-form button:hover {
            background-color: var(--font);
        }
    </style>
</head>
<body>
    <div class="ca-container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Tambah Akun Kasir</h2>
            </div>
            <div class="link">
                <a href="stores-page.php"><button>Kembali</button></a>
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