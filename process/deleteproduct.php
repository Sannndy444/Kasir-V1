<?php
require '../config/config.php'; // Sesuaikan jalur file konfigurasi
session_start();

// Periksa apakah pengguna memiliki akses dan parameter `product_id` ada
if ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'kasir') {
    echo "<script>alert('Access denied.'); window.location.href = '../pages/dashboard-page.php';</script>";
    exit;
}

if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    $store_id = $_SESSION['store_id'];

    // Pastikan produk yang akan dihapus milik store_id yang sedang login
    $query = "DELETE FROM products WHERE product_id = '$product_id' AND store_id = '$store_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Produk berhasil dihapus.'); window.location.href = '../pages/stores-page.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.'); window.location.href = '../pages/stores-page.php';</script>";
    }
} else {
    echo "<script>alert('ID produk tidak ditemukan.'); window.location.href = '../pages/stores-page.php';</script>";
}