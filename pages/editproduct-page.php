<?php
require '../config/config.php';
session_start();

// Periksa apakah pengguna memiliki akses ke halaman ini
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'kasir')) {
    echo "<script>alert('Access denied.');</script>";
    header("Location: ../pages/dashboard-page.php");
    exit;
}

// Ambil data produk berdasarkan product_id
$product_id = $_GET['product_id'];
$product_query = "SELECT * FROM products WHERE product_id = '$product_id'";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

if (!$product) {
    echo "<script>alert('Produk tidak ditemukan.'); window.location.href = '../pages/stores-page.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <!-- My style -->
    <link rel="stylesheet" href="../css/styles.css">

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
            font-family: 'Poppins', sans-serif;
            color: var(--font);
            background-color: var(--bg);
            padding: 20px;
        }

        .edit-container {
            display: flex;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background: var(--primary);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 60px;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
            color: var(--font);
        }

        .link {
            margin-bottom: 20px;
        }

        .link a {
            text-decoration: none;
        }

        .link button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .link button:hover {
            background-color: #333;
        }

        .editproduct-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .editproduct-form label {
            display: block;
            margin: 10px 0 5px;
            color: var(--font);
        }

        .editproduct-form input[type="text"],
        .editproduct-form input[type="number"],
        .editproduct-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .editproduct-form button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .editproduct-form input[type="file"] {
            background-color: var(--nav);
            color: var(--primary);
        }

        .editproduct-form input[type="file"]:hover {
            background-color: var(--font);
        }

        .editproduct-form button:hover {
            background-color: #333;
        }

        img {
            display: block;
            margin: 10px 0;
            width: 100px;
            border-radius: 5px;
        }

        ::file-selector-button {
            display: none;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Edit Product</h2>
            </div>
            <div class="link">
                <a href="stores-page.php"><button>Kembali</button></a>
            </div>
            <hr>
            <div class="editproduct-form">
                <form action="../process/editproduct.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <label for="pname">Nama Produk:</label>
                    <input type="text" id="pname" name="pname" value="<?php echo $product['product_name']; ?>" required><br>

                    <label for="price">Harga Produk:</label>
                    <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required><br>

                    <label for="stock">Stok Produk:</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required><br>

                    <label for="img">Gambar Produk:</label>
                    <input type="file" id="img" name="img"><br>
                    <img src="../uploads/<?php echo $product['image']; ?>" alt="Product Image" width="100"><br>

                    <button type="submit" name="update">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
