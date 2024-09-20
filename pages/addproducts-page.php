<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

    <!-- My style -->
    <link rel="stylesheet" href="../css/styles.css">
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
                <label for="original_price">Harga Asli : </label>
                <input type="number" name="original_price" id="original_price" step="0.01" required> <br>
                <label for="selling_price">Harga Jual : </label>
                <input type="number" name="selling_price" id="selling_price" step="0.01" required> <br>
                <label for="stock">Stok Barang : </label>
                <input type="number" name="stock" id="stock" required> <br>
                <label for="img">Upload Gambar : </label> 
                <input type="file" name="img" id="img" required>
                <input type="hidden" name="stores_id" value="<?php echo $_SESSION['store_id'];?>">
                <button type="submit" name="submit">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>
