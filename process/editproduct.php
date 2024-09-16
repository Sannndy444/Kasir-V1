<?php
require '../config/config.php';
session_start();

if (isset($_POST['update']) && isset($_SESSION['users_id'])) {
    $product_id = $_POST['product_id'];
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Update gambar jika ada gambar baru yang diupload
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['img']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);

        // Hapus gambar lama jika ada
        $old_image_query = "SELECT image FROM products WHERE product_id = '$product_id'";
        $old_image_result = mysqli_query($conn, $old_image_query);
        $old_image = mysqli_fetch_assoc($old_image_result)['image'];
        if (file_exists("../uploads/" . $old_image)) {
            unlink("../uploads/" . $old_image);
        }

        // Pindahkan gambar baru ke folder uploads
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            $query = "UPDATE products SET product_name = '$pname', price = '$price', stock = '$stock', image = '$image' WHERE product_id = '$product_id'";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah gambar.'); window.location.href = '../pages/editproduct-page.php?product_id=$product_id';</script>";
            exit;
        }
    } else {
        // Jika tidak ada gambar baru, update data produk kecuali gambar
        $query = "UPDATE products SET product_name = '$pname', price = '$price', stock = '$stock' WHERE product_id = '$product_id'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location.href = '../pages/stores-page.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = '../pages/editproduct-page.php?product_id=$product_id';</script>";
    }
} else {
    echo "<script>alert('Anda perlu login untuk mengupdate produk.'); window.location.href = '../pages/login-page.php';</script>";
}
