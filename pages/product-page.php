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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
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
                    echo    '<td><img src="../uploads/' . $product['image'] . '" alt="" width="100rem" height="100rem" overflow="hidden"></td>';
                    echo    '<td>' . $product['product_name'] . '</td>';
                    echo    '<td>' . $product['price'] . '</td>';
                    echo    '<td>' . $product['stock'] . '</td>';
                    echo    '<td>
                            <a href="editproduct-page.php?product_id=' . $product['product_id'] . '">Edit</a>
                            <a href="../process/deleteproduct.php?product_id=' . $product['product_id'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\')">Delete</a>
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
</body>
</html>