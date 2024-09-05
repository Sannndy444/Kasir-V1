<?php
require '../config/config.php';
session_start();

if(isset($_POST['submit']) && isset($_SESSION['users_id'])){
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $store_id = $_SESSION['store_id'];

    if(!$store_id) {
        echo "<script>alert('Anda belum memiliki toko. Silakan buat toko terlebih dahulu.'); window.location.href = '../pages/store-page.php';</script>";
        exit;
    }

    // Mengolah upload gambar
    if(isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK){
        $image = $_FILES['img']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);

        // Cek apakah file sudah ada atau ada error
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            $query = "INSERT INTO products (product_name, price, stock, store_id, image) VALUES ('$pname', '$price', '$stock', '$store_id', '$image')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href = '../pages/products-page.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah gambar.');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah gambar atau tidak ada gambar yang diunggah.');</script>";
    }
} else {
    echo "<script>alert('Anda perlu login untuk menambahkan produk.');</script>";
}
