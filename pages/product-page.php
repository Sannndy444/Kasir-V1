<?php
require '../config/config.php';
// session_start();

// Memeriksa apakah pengguna memiliki akses ke halaman ini
// if ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'kasir') {
//     echo "<script>alert('Access denied.');</script>";
//     header("Location: ../pages/dashboard-page.php");
//     exit;
// }

$store_id = $_SESSION['store_id']; // Mengambil store_id dari session

// Ambil data produk dari database berdasarkan store_id
$product_query = "SELECT * FROM products WHERE store_id = '$store_id'";
$product_result = mysqli_query($conn, $product_query);

include '../process/product.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

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

        .pro-container {
            max-width: 123rem;
            margin: 0;
            background: var(--primary);
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .judul-product {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-product h2 {
            padding: 2rem 0 0 0;
        }

        .tabel-product table {
            width: 100%;
            border-collapse: collapse;
        }

        .tabel-product th, .tabel-product td {
            border: 1px solid #ddd;
            padding: 10px;
            /* text-align: left; */
        }

        .tabel-product th {
            background-color: var(--nav);
            color: var(--primary);
        }

        .tabel-product img {
            max-width: 200px;
            max-height: 200px;
            height: auto;
        }

        .tabel-product a {
            margin-right: 10px;
            color: var(--font);
            text-decoration: none;
        }

        .tabel-product a:hover {
            text-decoration: underline;
        }

        .tabel-product a {
            text-decoration: none;
        }

        .tabel-product .edit-btn {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            padding: 1rem 1rem 1rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .tabel-product .del-btn {
            background-color: #FF0000;
            color: white;
            border: none;
            cursor: pointer;
            padding: 1rem 1rem 1rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .tabel-product button:hover {
            background-color: var(--font);
        }

        @media (max-width: 600px) {
            .tabel-product table {
                font-size: 14px;
            }

            .tabel-product img {
                max-width: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="pro-container">
            <div class="judul-product">
                <h2>
                    Stock Product
                </h2>
            </div>
            <div class="tabel-product">
            <?php
                // Cek apakah ada produk yang diambil dari database
                if (mysqli_num_rows($product_result) > 0) {
                    echo '<table>';
                    echo '<tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr>';
                    
                    // Tampilkan data produk
                    while ($product = mysqli_fetch_assoc($product_result)) {
                        echo '<tr>';
                        echo    '<td><img src="../uploads/' . $product['image'] . '" alt="" width="150rem" height="150rem" overflow="hidden"></td>';
                        echo    '<td>' . $product['product_name'] . '</td>';
                        echo    '<td>' . $product['price'] . '</td>';
                        echo    '<td>' . $product['stock'] . '</td>';
                        echo    '<td>
                                <a href="editproduct-page.php?product_id=' . $product['product_id'] . '"><button class="edit-btn">Edit</button></a>
                                <a href="../process/deleteproduct.php?product_id=' . $product['product_id'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\')"><button class="del-btn">Delete</button></a>
                                </td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'No products available.';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>