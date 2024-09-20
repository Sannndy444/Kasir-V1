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
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
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
</body>
</html>
