<?php
require '../config/config.php';
// session_start();

// Memeriksa apakah pengguna memiliki akses ke halaman ini
if ($_SESSION["role"] !== 'admin') {
    echo "<script>alert('Access denied.');</script>";
    header("Location: ../pages/dashboard-page.php");
    exit;
}

include '../process/product.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
    <div class="container">
        <div class="judul-product">
            <h2>
                Stock Product
            </h2>
        </div>
        <div class="tabel-product">
        <?php echo $_SESSION['store_id']; ?> <br>
        <table>
            <tr>
                <td>Image</td>
                <td>:</td>
                <td><img src="../uploads/<?php echo $image; ?>" alt="" width="100rem">
                    </td>
            </tr>
            <tr>
                <td>Namara Barang</td>
                <td>:</td>
                <td><?php echo $pname; ?></td>
            </tr>
            <tr>
                <td>Harga Barang</td>
                <td>:</td>
                <td><?php echo $price; ?></td>
            </tr>
            <tr>
                <td>Stock Barang</td>
                <td>:</td>
                <td><?php echo $pstock; ?></td>
            </tr>
        </table>
        </div>
    </div>
</body>
</html>